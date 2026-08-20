<?php
session_start();
require("connection.php");
require("function.php");
check_login();
include("header.php");
// 1. الاتصال بقاعدة البيانات


if ($connection->connect_error) { // التحقق مما إذا كان هناك خطأ في الاتصال
    die("فشل الاتصال بقاعدة البيانات: " . $connection->connect_error); // إيقاف تنفيذ الصفحة وعرض رسالة الخطأ
} // نهاية شرط التحقق من الاتصال

$connection->set_charset("utf8mb4"); // ضبط ترميز الاتصال لدعم كافة النصوص والرموز بما فيها العربية

// 2. معالجة البحث الرئيسي
$search_query = ""; // تعريف متغير فارغ لتخزين اسم الدواء المبحوث عنه
$selected_location = ""; // تعريف متغير فارغ لتخزين المنطقة أو المدينة المحددة
$results = []; // إنشاء مصفوفة فارغة لتخزين نتائج البحث المرجعة
$searched = false; // متغير منطقي لمعرفة ما إذا تم إجراء عملية بحث أم لا

if (isset($_GET['medicine']) && !empty(trim($_GET['medicine']))) { // التحقق من إرسال نموذج البحث واحتوائه على اسم دواء غير فارغ
    $search_query = trim($_GET['medicine']); // إزالة الفراغات الزائدة من بداية ونهاية اسم الدواء وحفظه
    $selected_location = isset($_GET['location']) ? trim($_GET['location']) : ""; // حفظ قيمة المدينة المحددة إن وجدت أو جعلها فارغة
    $searched = true; // تغيير قيمة المتغير لتأكيد أنه تم إجراء البحث

    // استعلام البحث الداعم للعربي والإنجليزي
    $sql = "SELECT 
                pharmacies.name AS pharmacy_name, 
                pharmacies.address AS pharmacy_address, 
                pharmacies.phone AS pharmacy_phone,
                medicines.name AS medicine_name,
                pharmacy_medicines.quantity,
                pharmacy_medicines.price
            FROM pharmacy_medicines 
            JOIN pharmacies ON pharmacy_medicines.pharmacy_id = pharmacies.id 
            JOIN medicines ON pharmacy_medicines.medicine_id = medicines.id 
            WHERE LOWER(medicines.name) LIKE LOWER(?)"; // كتابة استعلام SQL لربط الجداول والبحث عن اسم الدواء دون التأثر بحالة الأحرف

    if (!empty($selected_location)) { // في حال تم اختيار مدينة أو منطقة محددة للفلترة
        $sql .= " AND pharmacies.address LIKE ?"; // إضافة شرط البحث بحسب العنوان فقط (لا يوجد عمود city في الجدول)
    } // نهاية شرط فلترة الموقع

    $sql .= " AND pharmacy_medicines.quantity > 0 ORDER BY pharmacy_medicines.quantity DESC"; // ترتيب النتائج تنازلياً حسب الكمية وتصفية الأدوية المتوفرة فقط

    $stmt = $connection->prepare($sql); // تجهيز الاستعلام الآمن للحماية من هجمات SQL Injection

    if (!empty($selected_location)) { // إذا كان البحث يتضمن الموقع
        $param_med = "%" . $search_query . "%"; // إعداد نص البحث عن الدواء مع العلامات البديلة %
        $param_loc = "%" . $selected_location . "%"; // إعداد نص البحث عن الموقع مع العلامات البديلة %
        $stmt->bind_param("ss", $param_med, $param_loc); // ربط المتغيرين بالاستعلام بنوع نصوص (String)
    } else { // إذا كان البحث بدون تحديد موقع
        $param_med = "%" . $search_query . "%"; // إعداد نص البحث عن الدواء
        $stmt->bind_param("s", $param_med); // ربط متغير الدواء بالاستعلام
    } // نهاية إعداد المعاملات

    $stmt->execute(); // تنفيذ الاستعلام التجهيزي
    $get_result = $stmt->get_result(); // استخراج مجموعة النتائج المرجعة من الاستعلام

    while ($row = $get_result->fetch_assoc()) { // الدوران على النتائج وصفاً صفاً كـ associative array
        $results[] = $row; // إضافة كل صف نتائج إلى مصفوفة النتائج الرئيسية
    } // نهاية حلقة الدوران
    $stmt->close(); // إغلاق الاستعلام المُجهز لتحرير الموارد
} // نهاية معالجة البحث
?>

<!DOCTYPE html> <!-- تعريف نوع المستند كـ HTML5 -->
<html lang="ar" dir="rtl" id="htmlTag"> <!-- بداية وسم html بلغة عربية واتجاه من اليمين لليسار مع معرف فريد -->
<head> <!-- بداية رأس الصفحة لاستدعاء الإعدادات والتنسيقات -->
    <meta charset="UTF-8"> <!-- ضبط الترميز العالمي للصفحة -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- ضبط التجاوب مع شاشات الهواتف والأجهزة المختلفة -->
    <title>البحث عن الأدوية - صيدليتي</title> <!-- عنوان الصفحة المكتوب في شريط المتصفح -->
    <link rel="stylesheet" href="CSS/style.css"/>
    
</head> <!-- نهاية رأس الصفحة -->
<body> <!-- بداية جسم الصفحة الم отображение للعميل -->

    <!-- المحتوى الرئيسي -->
    <main class="main-content"> <!-- حاوية المحتوى الرئيسي -->
        <div class="container"> <!-- الحاوية الداخلية للتوسيط -->
            <header> <!-- ترويسة محتوى الصفحة -->
                <h1 id="mainTitle">مرحباً بك في منصة صيدليتي 💊</h1> <!-- العنوان الرئيسي للتطبيق -->
                <p id="mainDesc">ابحث عن الدواء وسنعرض لك الصيدليات المتوفر بها فوراً</p> <!-- الوصف التوضيحي الخدمي -->
            </header> <!-- نهاية الترويسة -->

            <div class="search-box"> <!-- حاوية صندوق نموذج البحث -->
                <form class="search-form" method="GET" action="home.php"> <!-- نموذج إرسال البيانات بطريقة GET إلى نفس الصفحة -->
                    <input 
                        type="text" 
                        name="medicine" 
                        id="searchInput"
                        placeholder="اكتب اسم الدواء (مثال: Panadol)..." 
                        value="<?php echo htmlspecialchars($search_query); ?>" 
                        required
                    > <!-- حقل إدخال اسم الدواء مع الحماية من ثغرة XSS وطبع القيمة السابقة -->
                    
                    <select name="location" id="locationSelect"> <!-- قائمة المنسدلة لاختيار المنطقة -->
                        <option value="" class="opt-all">كل المناطق</option> <!-- الخيار الافتراضي لعرض كافة المناطق -->
                        <option value="القاهرة" class="opt-cairo" <?php echo ($selected_location == 'القاهرة') ? 'selected' : ''; ?>>القاهرة</option> <!-- خيار القاهرة والحفاظ على اختياره -->
                        <option value="الجيزة" class="opt-giza" <?php echo ($selected_location == 'الجيزة') ? 'selected' : ''; ?>>الجيزة</option> <!-- خيار الجيزة والحفاظ على اختياره -->
                        <option value="الأسكندرية" class="opt-alex" <?php echo ($selected_location == 'الأسكندرية') ? 'selected' : ''; ?>>الأسكندرية</option> <!-- خيار الأسكندرية والحفاظ على اختياره -->
                    </select> <!-- نهاية القائمة المنسدلة -->

                    <button type="submit" id="btnSubmit">بحث</button> <!-- زر إرسال النموذج -->
                </form> <!-- نهاية نموذج البحث -->
            </div> <!-- نهاية صندوق البحث -->

            <div class="results-section"> <!-- قسم عرض نتائج البحث -->
                <?php if ($searched): ?> <!-- التحقق مما إذا كان تم تنفيذ عملية البحث -->
                    <h2><span class="txt-res-for">نتائج البحث عن:</span> "<?php echo htmlspecialchars($search_query); ?>"</h2> <!-- عرض النص المبحوث عنه بأمان -->
                    
                    <?php if (count($results) > 0): ?> <!-- التحقق من وجود أية نتائج في المصفوفة -->
                        <?php foreach ($results as $item): ?> <!-- التكرار لعرض كل صيدلية متوفر لديها الدواء -->
                            <div class="pharmacy-card"> <!-- حاوية بطاقة الصيدلية -->
                                <div> <!-- القسم الأيمن: بيانات الصيدلية والدواء -->
                                    <h3><?php echo htmlspecialchars($item['pharmacy_name']); ?></h3> <!-- طباعة اسم الصيدلية -->
                                    <p><strong class="lbl-med">الدواء المطلوب:</strong> <?php echo htmlspecialchars($item['medicine_name']); ?></p> <!-- طباعة اسم الدواء المتاح -->
                                    <p><strong class="lbl-addr">العنوان:</strong> <?php echo htmlspecialchars($item['pharmacy_address']); ?></p> <!-- طباعة عنوان الصيدلية -->
                                    <p><strong class="lbl-phone">الهاتف:</strong> <?php echo htmlspecialchars($item['pharmacy_phone'] ?? 'غير متوفر'); ?></p> <!-- طباعة رقم التليفون إن وجد -->
                                </div> <!-- نهاية قسم البيانات النصية -->
                                <div style="text-align: center;"> <!-- القسم الأيسر: الكمية والسعر والتواصل -->
                                        <span class="badge"><span class="lbl-avail">متوفر</span> (<?php echo $item['quantity']; ?> <span class="lbl-pcs">قطعة</span>)</span> <!-- طباعة الكمية المتاحة في المخزون -->                                     <?php if (isset($item['price'])): ?> <!-- التحقق من تسجيل سعر للدواء -->
                                        <p style="margin: 8px 0; font-weight: bold; color: var(--primary);"> <!-- تنسيق عرض السعر -->
                                            <?php echo $item['price']; ?> <span class="lbl-egp">جنيه</span> <!-- طباعة سعر الدواء مع العملة -->
                                        </p> <!-- نهاية فقرة السعر -->
                                    <?php endif; ?> <!-- نهاية شرط وجود السعر -->
                                    
                                    <?php if (!empty($item['pharmacy_phone'])): ?> <!-- التحقق من إدخال رقم الهاتف لاتصال مباشر -->
                                        <a href="tel:<?php echo $item['pharmacy_phone']; ?>" class="call-btn btn-call">📞 اتصل بالصيدلية</a> <!-- رابط اتصل بنا ينقر مباشرة لبدء المكالمة -->
                                    <?php endif; ?> <!-- نهاية شرط رقم الهاتف -->
                                </div> <!-- نهاية الجانب الأيسر للبطاقة -->
                            </div> <!-- نهاية بطاقة الصيدلية -->
                        <?php endforeach; ?> <!-- نهاية حلقة foreach لعرض جميع النتائج -->
                    <?php else: ?> <!-- في حال كانت النتيجة فارغة ولا يوجد أدوية -->
                        <div style="text-align: center; background: var(--card-bg); padding: 30px; border-radius: 10px;"> <!-- مربع تنبيه التوفر -->
                            <p class="txt-no-res">عذراً، لم نجد أي صيدلية يتوفر لديها هذا الدواء في المنطقة المحددة.</p> <!-- رسالة التنبيه ببعدم وجود نتائج -->
                        </div> <!-- نهاية مربع التنبيه -->
                    <?php endif; ?> <!-- نهاية شرط التحقق من عدد النتائج -->
                <?php endif; ?> <!-- نهاية شرط التحقق من عملية البحث -->
            </div> <!-- نهاية قسم النتائج -->
        </div> <!-- نهاية الحاوية -->
    </main> <!-- نهاية المحتوى الرئيسي -->

    <script> /* بداية أكواد JavaScript */
        function toggleDarkMode() { // دالة التبديل بين الوضع الداكن والفاتح
            document.body.classList.toggle('dark-mode'); // إضافة أو إزالة كلاس dark-mode من عنصر body
        } // نهاية دالة toggleDarkMode

        // دالة تحويل اللغة التفاعلية
        function toggleLanguage() { // دالة التبديل بين اللغتين العربية والإنجليزية ديناميكياً
            const html = document.getElementById('htmlTag'); // جلب عنصر HTML الرئيسي
            const isAr = html.getAttribute('dir') === 'rtl'; // التحقق هل الاتجاه الحالي من اليمين لليسار (عربي)

            if (isAr) { // إذا كانت اللغة الحالية هي العربية
                // تحويل إلى الإنجليزي
                html.setAttribute('dir', 'ltr'); // تغيير الاتجاه من اليسار لليمين
                html.setAttribute('lang', 'en'); // تغيير وسم اللغة إلى إنجليزي
                
                document.getElementById('menuTitle').innerText = "Main Menu"; // ترجمة عنوان القائمة الجانبية
                document.getElementById('linkProfile').innerText = "👤 User Profile"; // ترجمة رابط الملف الشخصي
                document.getElementById('linkSearch').innerText = "🔍 Medicine Search"; // ترجمة رابط البحث
                document.getElementById('btnDark').innerText = "🌙 / ☀️ Dark Mode"; // ترجمة نص زر الوضع الداكن
                document.getElementById('btnLang').innerText = "🌐 العربية"; // تغيير نص زر اللغة
                
                document.getElementById('mainTitle').innerText = "Welcome to My Pharmacy 💊"; // ترجمة العنوان الرئيسي
                document.getElementById('mainDesc').innerText = "Search for medicines and find available pharmacies instantly"; // ترجمة الوصف الفرعي
                document.getElementById('searchInput').placeholder = "Type medicine name (e.g. Panadol)..."; // ترجمة نص التوضيح داخل حقل البحث
                document.getElementById('btnSubmit').innerText = "Search"; // ترجمة نص زر البحث

                // تحويل باقي نصوص النتائج والخيارات
                document.querySelector('.opt-all').innerText = "All Regions"; // ترجمة خيار كل المناطق
                document.querySelector('.opt-cairo').innerText = "Cairo"; // ترجمة خيار القاهرة
                document.querySelector('.opt-giza').innerText = "Giza"; // ترجمة خيار الجيزة
                document.querySelector('.opt-alex').innerText = "Alexandria"; // ترجمة خيار الأسكندرية

                document.querySelectorAll('.lbl-med').forEach(e => e.innerText = "Medicine:"); // ترجمة كلمة الدواء المطلوب
                document.querySelectorAll('.lbl-addr').forEach(e => e.innerText = "Address:"); // ترجمة كلمة العنوان
                document.querySelectorAll('.lbl-phone').forEach(e => e.innerText = "Phone:"); // ترجمة كلمة الهاتف
                document.querySelectorAll('.lbl-avail').forEach(e => e.innerText = "Available"); // ترجمة كلمة متوفر
                document.querySelectorAll('.lbl-pcs').forEach(e => e.innerText = "pcs"); // ترجمة وحدة قطعة
                document.querySelectorAll('.lbl-egp').forEach(e => e.innerText = "EGP"); // ترجمة اسم العملة (جنيه)
                document.querySelectorAll('.btn-call').forEach(e => e.innerText = "📞 Call Pharmacy"); // ترجمة نص زر الاتصال
            } else { // إذا كانت اللغة الحالية إنجليزية ويريد العودة للعربية
                // العودة إلى العربي
                html.setAttribute('dir', 'rtl'); // تغيير الاتجاه من اليمين لليسار
                html.setAttribute('lang', 'ar'); // تغيير وسم اللغة للغة العربية
                
                document.getElementById('menuTitle').innerText = "القائمة الرئيسية"; // إعادة النص للغة العربية
                document.getElementById('linkProfile').innerText = "👤 ملف المستخدم"; // إعادة نص رابط الملف الشخصي
                document.getElementById('linkSearch').innerText = "🔍 البحث عن الأدوية"; // إعادة نص رابط البحث
                document.getElementById('btnDark').innerText = "🌙 / ☀️ الوضع الداكن"; // إعادة نص زر الوضع الداكن
                document.getElementById('btnLang').innerText = "🌐 English"; // إعادة نص زر اللغة
                
                document.getElementById('mainTitle').innerText = "مرحباً بك في منصة صيدليتي 💊"; // إعادة العنوان الرئيسي بالعربية
                document.getElementById('mainDesc').innerText = "ابحث عن الدواء وسنعرض لك الصيدليات المتوفر بها فوراً"; // إعادة الوصف بالعربية
                document.getElementById('searchInput').placeholder = "اكتب اسم الدواء (مثال: Panadol)..."; // إعادة نص التوضيح بحقل البحث
                document.getElementById('btnSubmit').innerText = "بحث"; // إعادة نص زر البحث

                document.querySelector('.opt-all').innerText = "كل المناطق"; // إعادة نص خيار كل المناطق
                document.querySelector('.opt-cairo').innerText = "القاهرة"; // إعادة نص خيار القاهرة
                document.querySelector('.opt-giza').innerText = "الجيزة"; // إعادة نص خيار الجيزة
                document.querySelector('.opt-alex').innerText = "الأسكندرية"; // إعادة نص خيار الأسكندرية

                document.querySelectorAll('.lbl-med').forEach(e => e.innerText = "الدواء المطلوب:"); // إعادة ترجمة كلمة الدواء المطلوب
                document.querySelectorAll('.lbl-addr').forEach(e => e.innerText = "العنوان:"); // إعادة ترجمة كلمة العنوان
                document.querySelectorAll('.lbl-phone').forEach(e => e.innerText = "الهاتف:"); // إعادة ترجمة كلمة الهاتف
                document.querySelectorAll('.lbl-avail').forEach(e => e.innerText = "متوفر"); // إعادة ترجمة كلمة متوفر
                document.querySelectorAll('.lbl-pcs').forEach(e => e.innerText = "قطعة"); // إعادة ترجمة قطعة
                document.querySelectorAll('.lbl-egp').forEach(e => e.innerText = "جنيه"); // إعادة ترجمة العملة
                document.querySelectorAll('.btn-call').forEach(e => e.innerText = "📞 اتصل بالصيدلية"); // إعادة نص زر الاتصال
            } // نهاية شرط التبديل
        } // نهاية دالة toggleLanguage
    </script> <!-- نهاية سكريبت JavaScript -->
</body> <!-- نهاية جسم الصفحة -->
</html> <!-- نهاية ملف HTML -->
<?php include("footer.php");?>