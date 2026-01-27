/**
 * الدفتر الرقمي - ملف JavaScript الرئيسي
 * يحتوي على جميع الوظائف التفاعلية للتطبيق
 */

// إعداد CSRF Token
window.Laravel = {
    csrfToken: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
};

// ===================================
// وظائف الشريط الجانبي
// ===================================

/**
 * تبديل عرض الشريط الجانبي على الهواتف المحمولة
 */
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    
    sidebar.classList.toggle('show');
    overlay.classList.toggle('show');
}

/**
 * إغلاق الشريط الجانبي
 */
function closeSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    
    sidebar.classList.remove('show');
    overlay.classList.remove('show');
}

// ===================================
// وظائف الرسوم المتحركة
// ===================================

/**
 * تحريك الأرقام تدريجياً
 * @param {string} elementId - معرف العنصر
 * @param {number} targetNumber - الرقم المستهدف
 * @param {number} duration - مدة الحركة بالميلي ثانية
 */
function animateNumber(elementId, targetNumber, duration = 1500) {
    const element = document.getElementById(elementId);
    if (!element) return;
    
    const startNumber = 0;
    const increment = targetNumber / (duration / 16);
    let currentNumber = startNumber;

    const timer = setInterval(() => {
        currentNumber += increment;
        if (currentNumber >= targetNumber) {
            currentNumber = targetNumber;
            clearInterval(timer);
        }
        element.textContent = Math.floor(currentNumber).toLocaleString();
    }, 16);
}

/**
 * إضافة تأثير الظهور التدريجي للبطاقات
 */
function addFadeInAnimation() {
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        setTimeout(() => {
            card.classList.add('fade-in');
        }, index * 100);
    });
}

// ===================================
// وظائف الإشعارات
// ===================================

/**
 * عرض إشعار منبثق
 * @param {string} message - نص الرسالة
 * @param {string} type - نوع الإشعار (success, danger, warning, info)
 * @param {number} duration - مدة العرض بالميلي ثانية
 */
function showToast(message, type = 'info', duration = 3000) {
    // إنشاء عنصر الإشعار
    const toast = document.createElement('div');
    toast.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    toast.style.cssText = 'top: 20px; left: 20px; z-index: 9999; min-width: 300px;';
    toast.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
    `;
    
    // إضافة الإشعار إلى الصفحة
    document.body.appendChild(toast);
    
    // إزالة الإشعار تلقائياً
    setTimeout(() => {
        if (toast.parentNode) {
            toast.parentNode.removeChild(toast);
        }
    }, duration);
}

/**
 * عرض إشعار تأكيد
 * @param {string} message - نص الرسالة
 * @param {function} onConfirm - دالة التأكيد
 * @param {function} onCancel - دالة الإلغاء
 */
function showConfirmDialog(message, onConfirm, onCancel = null) {
    if (confirm(message)) {
        if (typeof onConfirm === 'function') {
            onConfirm();
        }
    } else {
        if (typeof onCancel === 'function') {
            onCancel();
        }
    }
}

// ===================================
// وظائف التحميل
// ===================================

/**
 * عرض مؤشر التحميل
 * @param {string} elementId - معرف العنصر
 */
function showLoading(elementId) {
    const element = document.getElementById(elementId);
    if (element) {
        element.style.display = 'block';
    }
}

/**
 * إخفاء مؤشر التحميل
 * @param {string} elementId - معرف العنصر
 */
function hideLoading(elementId) {
    const element = document.getElementById(elementId);
    if (element) {
        element.style.display = 'none';
    }
}

// ===================================
// وظائف النماذج
// ===================================

/**
 * تنظيف النموذج
 * @param {string} formId - معرف النموذج
 */
function clearForm(formId) {
    const form = document.getElementById(formId);
    if (form) {
        form.reset();
    }
}

/**
 * التحقق من صحة النموذج
 * @param {string} formId - معرف النموذج
 * @returns {boolean} - صحة النموذج
 */
function validateForm(formId) {
    const form = document.getElementById(formId);
    if (!form) return false;
    
    return form.checkValidity();
}

// ===================================
// وظائف البحث والتصفية
// ===================================

/**
 * تصفية العناصر حسب النص
 * @param {string} searchText - نص البحث
 * @param {Array} items - قائمة العناصر
 * @param {Array} searchFields - الحقول المراد البحث فيها
 * @returns {Array} - العناصر المفلترة
 */
function filterItems(searchText, items, searchFields) {
    if (!searchText) return items;
    
    const searchTerm = searchText.toLowerCase();
    return items.filter(item => {
        return searchFields.some(field => {
            const value = item[field];
            return value && value.toString().toLowerCase().includes(searchTerm);
        });
    });
}

/**
 * ترتيب العناصر
 * @param {Array} items - قائمة العناصر
 * @param {string} field - الحقل المراد الترتيب حسبه
 * @param {string} direction - اتجاه الترتيب (asc, desc)
 * @returns {Array} - العناصر مرتبة
 */
function sortItems(items, field, direction = 'asc') {
    return items.sort((a, b) => {
        const aValue = a[field];
        const bValue = b[field];
        
        if (direction === 'asc') {
            return aValue > bValue ? 1 : -1;
        } else {
            return aValue < bValue ? 1 : -1;
        }
    });
}

// ===================================
// وظائف التصدير
// ===================================

/**
 * تصدير البيانات إلى CSV
 * @param {Array} data - البيانات المراد تصديرها
 * @param {string} filename - اسم الملف
 */
function exportToCSV(data, filename = 'export.csv') {
    if (!data.length) {
        showToast('لا توجد بيانات للتصدير', 'warning');
        return;
    }
    
    const headers = Object.keys(data[0]);
    const csvContent = [
        headers.join(','),
        ...data.map(row => headers.map(header => row[header]).join(','))
    ].join('\n');
    
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    const url = URL.createObjectURL(blob);
    
    link.setAttribute('href', url);
    link.setAttribute('download', filename);
    link.style.visibility = 'hidden';
    
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

// ===================================
// وظائف المساعدة
// ===================================

/**
 * تنسيق الأرقام
 * @param {number} number - الرقم
 * @param {string} currency - العملة
 * @returns {string} - الرقم منسق
 */
function formatNumber(number, currency = 'ر.س') {
    return `${number.toLocaleString()} ${currency}`;
}

/**
 * تنسيق التاريخ
 * @param {Date|string} date - التاريخ
 * @returns {string} - التاريخ منسق
 */
function formatDate(date) {
    const d = new Date(date);
    return d.toLocaleDateString('ar-SA');
}

/**
 * الحصول على لون الرصيد
 * @param {number} balance - الرصيد
 * @param {string} type - نوع الحساب
 * @returns {string} - فئة CSS للون
 */
function getBalanceClass(balance, type) {
    if (balance === 0) return 'balance-zero';
    if (type === 'customer') {
        return balance > 0 ? 'balance-positive' : 'balance-negative';
    } else {
        return balance < 0 ? 'balance-negative' : 'balance-positive';
    }
}

/**
 * الحصول على تسمية الرصيد
 * @param {number} balance - الرصيد
 * @param {string} type - نوع الحساب
 * @returns {string} - تسمية الرصيد
 */
function getBalanceLabel(balance, type) {
    if (balance === 0) return 'متوازن';
    if (type === 'customer') {
        return balance > 0 ? 'مدين' : 'دائن';
    } else {
        return balance < 0 ? 'مستحق' : 'مدفوع';
    }
}

// ===================================
// تهيئة التطبيق
// ===================================

/**
 * تهيئة التطبيق عند تحميل الصفحة
 */
document.addEventListener('DOMContentLoaded', function() {
    // إضافة تأثير الظهور التدريجي للبطاقات
    addFadeInAnimation();
    
    // إعداد أحداث الشريط الجانبي للهواتف المحمولة
    const mobileToggle = document.querySelector('.mobile-toggle');
    if (mobileToggle) {
        mobileToggle.addEventListener('click', toggleSidebar);
    }
    
    const overlay = document.getElementById('overlay');
    if (overlay) {
        overlay.addEventListener('click', closeSidebar);
    }
    
    // إعداد أحداث إغلاق النوافذ المنبثقة بالضغط على Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            // إغلاق النوافذ المنبثقة المفتوحة
            const openModals = document.querySelectorAll('.modal.show');
            openModals.forEach(modal => {
                const modalInstance = bootstrap.Modal.getInstance(modal);
                if (modalInstance) {
                    modalInstance.hide();
                }
            });
            
            // إغلاق الشريط الجانبي على الهواتف
            closeSidebar();
        }
    });
    
    console.log('تم تحميل التطبيق بنجاح');
});

// تصدير الوظائف للاستخدام العام
window.DigitalLedger = {
    toggleSidebar,
    closeSidebar,
    animateNumber,
    addFadeInAnimation,
    showToast,
    showConfirmDialog,
    showLoading,
    hideLoading,
    clearForm,
    validateForm,
    filterItems,
    sortItems,
    exportToCSV,
    formatNumber,
    formatDate,
    getBalanceClass,
    getBalanceLabel
};

