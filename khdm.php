<?php

$clientData = [];
if (isset($_COOKIE['smasco_data'])) {
    $clientData = json_decode($_COOKIE['smasco_data'], true) ?? [];
}

$fullname = $clientData['fullname'] ?? '';
$phone = $clientData['phone'] ?? '';
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SMASCO – بيانات الخدمة المطلوبة</title>
  <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <style>
    * { box-sizing: border-box; }
    body {
      background: #f4f6f9;
      font-family: 'Tajawal', sans-serif;
      margin: 0;
      padding: 0;
    }
    .container {
      max-width: 480px;
      background: #fff;
      margin: 20px auto;
      padding: 24px;
      border-radius: 14px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.06);
    }
    @media (min-width: 768px) {
      .container { max-width: 600px; margin: 40px auto; padding: 30px; }
    }
    .logo { text-align: center; margin-bottom: 18px; }
    .logo img { width: 140px; max-width: 55%; height: auto; }
    .steps-wrapper { margin-bottom: 14px; }
    .steps {
      position: relative;
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 6px;
    }
    .steps::before {
      content: "";
      position: absolute;
      top: 16px;
      left: 7%;
      right: 7%;
      height: 2px;
      background: #e2e6ee;
      z-index: 1;
    }
    .step { position: relative; text-align: center; flex: 1; z-index: 2; }
    .step-circle {
      width: 32px;
      height: 32px;
      margin: 0 auto;
      border-radius: 50%;
      border: 2px solid #d0d4dd;
      background: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 14px;
      color: #80869a;
      font-weight: 600;
    }
    .step-label { margin-top: 6px; font-size: 12px; color: #6b7280; white-space: nowrap; }
    .step.active .step-circle { background: #1d8cf8; border-color: #1d8cf8; color: #fff; }
    .step.done .step-circle { background: #22c55e; border-color: #22c55e; color: #fff; }
    h2 { text-align: center; margin-bottom: 18px; color: #1e3556; font-weight: 700; font-size: 1.3rem; }
    .client-summary {
      margin-bottom: 16px;
      padding: 10px 14px;
      border-radius: 12px;
      border: 1px dashed #c7d2fe;
      background: linear-gradient(135deg, #eff6ff 0%, #eef2ff 100%);
    }
    .client-summary-title { font-size: 0.8rem; color: #6b7280; margin-bottom: 4px; }
    .client-summary-name { font-size: 0.95rem; font-weight: 700; color: #111827; }
    .client-summary-phone { font-size: 0.9rem; color: #1d4ed8; margin-top: 2px; }
    label { font-weight: 600; margin-top: 12px; display: block; font-size: 0.95rem; }
    input, select, textarea {
      width: 100%;
      padding: 11px 12px;
      margin-top: 6px;
      border-radius: 10px;
      border: 1px solid #d5d9df;
      font-size: 0.95rem;
      font-family: 'Tajawal', sans-serif;
      background: #fafafa;
      transition: .2s;
    }
    input:focus, select:focus, textarea:focus {
      border-color: #0080ff;
      background: #fff;
      outline: none;
      box-shadow: 0 0 0 2px rgba(0,128,255,0.12);
    }
    textarea { min-height: 80px; resize: vertical; }
    .hint { font-size: 0.8rem; color: #6b7280; margin-top: 3px; }
    .duration-box { margin-top: 8px; }
    .visit-duration-btn, .visit-period-btn, .visit-day-btn {
      padding: 12px 8px;
      background: #f9fafb;
      border: 2px solid #e5e7eb;
      border-radius: 10px;
      color: #374151;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.2s;
      font-family: 'Tajawal', sans-serif;
    }
    .visit-duration-btn:hover, .visit-period-btn:hover, .visit-day-btn:hover {
      border-color: #3b82f6;
      background: #eff6ff;
    }
    .visit-duration-btn.selected, .visit-period-btn.selected {
      background: #3b82f6;
      border-color: #2563eb;
      color: #fff;
    }
    .visit-day-btn.selected {
      background: #10b981;
      border-color: #059669;
      color: #fff;
    }
    .visit-day-btn.disabled {
      opacity: 0.5;
      cursor: not-allowed;
    }
    .date-input-wrapper {
      position: relative;
      margin-top: 8px;
    }
    .arabic-date-input {
      width: 100%;
      padding: 12px 45px 12px 12px;
      border-radius: 10px;
      border: 1px solid #d5d9df;
      font-size: 0.95rem;
      font-family: 'Tajawal', sans-serif;
      background: #fafafa url('data:image/svg+xml;charset=UTF-8,<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="%230080ff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>') no-repeat;
      background-position: left 12px center;
      transition: .2s;
      direction: rtl;
      text-align: right;
      color: #374151;
      cursor: pointer;
    }
    .arabic-date-input:focus {
      border-color: #0080ff;
      background: #fff;
      outline: none;
      box-shadow: 0 0 0 2px rgba(0,128,255,0.12);
    }
    .arabic-date-input::-webkit-calendar-picker-indicator {
      position: absolute;
      right: 12px;
      cursor: pointer;
      opacity: 0.7;
      transition: 0.2s;
      width: 20px;
      height: 20px;
    }
    .arabic-date-input::-webkit-calendar-picker-indicator:hover {
      opacity: 1;
    }
    .date-input-wrapper::before {
      content: "📅";
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      pointer-events: none;
      font-size: 1.2rem;
      z-index: 1;
    }
    
    .flatpickr-calendar {
      font-family: 'Tajawal', sans-serif !important;
      direction: rtl !important;
      box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
      border-radius: 12px !important;
      border: none !important;
    }
    .flatpickr-months {
      direction: rtl !important;
    }
    .flatpickr-current-month {
      font-family: 'Tajawal', sans-serif !important;
      font-size: 1.1rem !important;
      font-weight: 600 !important;
    }
    .flatpickr-weekdays {
      direction: rtl !important;
    }
    .flatpickr-weekday {
      font-family: 'Tajawal', sans-serif !important;
      font-weight: 600 !important;
      color: #6b7280 !important;
    }
    .flatpickr-days {
      direction: rtl !important;
    }
    .flatpickr-day {
      font-family: 'Tajawal', sans-serif !important;
      border-radius: 8px !important;
    }
    .flatpickr-day.selected {
      background: #0080ff !important;
      border-color: #0080ff !important;
    }
    .flatpickr-day.today {
      border-color: #0080ff !important;
    }
    .flatpickr-day:hover {
      background: #eff6ff !important;
      border-color: #3b82f6 !important;
    }
    .flatpickr-monthDropdown-months {
      font-family: 'Tajawal', sans-serif !important;
    }
    .flatpickr-monthDropdown-months, .numInput.cur-year {
      font-family: 'Tajawal', sans-serif !important;
      font-weight: 600 !important;
      padding: 4px 8px !important;
      border-radius: 6px !important;
      border: 1px solid #e5e7eb !important;
      background: #fff !important;
      cursor: pointer !important;
    }
    .flatpickr-monthDropdown-months:hover, .numInput.cur-year:hover {
      border-color: #3b82f6 !important;
      background: #eff6ff !important;
    }
    .numInput.cur-year {
      width: 70px !important;
      text-align: center !important;
    }
    .arrowUp, .arrowDown {
      border: none !important;
      width: 20px !important;
      height: 20px !important;
      display: flex !important;
      align-items: center !important;
      justify-content: center !important;
      cursor: pointer !important;
      transition: all 0.2s !important;
    }
    .arrowUp:hover, .arrowDown:hover {
      background: #eff6ff !important;
      border-radius: 4px !important;
    }
    .arrowUp:after {
      border-bottom-color: #6b7280 !important;
      border-width: 0 4px 5px 4px !important;
    }
    .arrowDown:after {
      border-top-color: #6b7280 !important;
      border-width: 5px 4px 0 4px !important;
    }
    .arrowUp:hover:after {
      border-bottom-color: #3b82f6 !important;
    }
    .arrowDown:hover:after {
      border-top-color: #3b82f6 !important;
    }
    .numInputWrapper {
      display: flex !important;
      flex-direction: column !important;
      align-items: center !important;
      gap: 2px !important;
    }
    .numInputWrapper .arrowUp {
      margin-bottom: 2px !important;
    }
    .numInputWrapper .arrowDown {
      margin-top: 2px !important;
    }
    .flatpickr-months .flatpickr-month {
      height: 40px !important;
    }
    .flatpickr-current-month {
      padding: 5px 0 !important;
      height: 35px !important;
      display: flex !important;
      align-items: center !important;
      justify-content: center !important;
      gap: 8px !important;
    }
    .flatpickr-monthDropdown-month {
      font-family: 'Tajawal', sans-serif !important;
    }
    button {
      width: 100%;
      padding: 13px;
      background: #0080ff;
      border: none;
      border-radius: 12px;
      color: #fff;
      font-size: 1rem;
      margin-top: 25px;
      cursor: pointer;
      transition: .2s;
      font-weight: 700;
    }
    button:hover { background: #0069d9; }
    .footer { text-align: center; margin-top: 22px; padding: 15px 10px 25px; color: #555; font-size: 13px; }
    .footer img { width: 120px; max-width: 50%; display: block; margin: 0 auto 10px; height: auto; }
    .overlay {
      position: fixed;
      inset: 0;
      background: rgba(0,0,0,0.5);
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 9999;
      padding: 20px;
    }
    .overlay.hidden { display: none; }
    .overlay-box {
      background: #ffffff;
      border-radius: 16px;
      padding: 25px 30px;
      text-align: center;
      max-width: 320px;
      width: 100%;
      box-shadow: 0 10px 30px rgba(0,0,0,0.18);
    }
    .spinner {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      border: 4px solid #e5e7eb;
      border-top-color: #1d8cf8;
      margin: 0 auto 12px;
      animation: spin 0.9s linear infinite;
    }
    @keyframes spin { to { transform: rotate(360deg); } }
    .check-icon {
      width: 52px;
      height: 52px;
      border-radius: 50%;
      background: #22c55e;
      margin: 0 auto 12px;
      display: none;
      align-items: center;
      justify-content: center;
      font-size: 26px;
      color: #fff;
    }
    .overlay-title { font-weight: 700; margin-bottom: 4px; color: #111827; }
    .overlay-text { font-size: 0.95rem; color: #4b5563; }
    .error-box {
      background: #fee2e2;
      border: 1px solid #fca5a5;
      padding: 12px 16px;
      border-radius: 10px;
      margin-top: 12px;
      display: none;
    }
    .error-box.show { display: block; }
    .error-text { color: #dc2626; font-size: 0.9rem; }
  </style>
</head>
<body>
  <div class="container">
    <div class="logo">
      <img src="image/smasco.png" alt="SMASCO Logo">
    </div>
    <div class="steps-wrapper">
      <div class="steps">
        <div class="step done">
          <div class="step-circle">1</div>
          <div class="step-label">بيانات العميل</div>
        </div>
        <div class="step active">
          <div class="step-circle">2</div>
          <div class="step-label">المواصفات</div>
        </div>
        <div class="step">
          <div class="step-circle">3</div>
          <div class="step-label">تأكيد الطلب</div>
        </div>
      </div>
    </div>
    <div class="client-summary">
      <div class="client-summary-title">بيانات العميل الحالية</div>
      <div class="client-summary-name" id="displayFullname">👤 <?php echo htmlspecialchars($fullname ?: 'لم يتم إدخال اسم بعد', ENT_QUOTES, 'UTF-8'); ?></div>
      <div class="client-summary-phone" id="displayPhone">📱 <?php echo htmlspecialchars($phone ?: 'لم يتم إدخال رقم جوال بعد', ENT_QUOTES, 'UTF-8'); ?></div>
    </div>

    <script>
      
      (function updateClientDataFromStorage() {
        const displayFullname = document.getElementById('displayFullname');
        const displayPhone = document.getElementById('displayPhone');
        
        try {
          const savedData = localStorage.getItem('smasco_data');
          if (savedData) {
            const data = JSON.parse(savedData);
            
            if (displayFullname && data.fullname && displayFullname.textContent.includes('لم يتم إدخال اسم')) {
              displayFullname.textContent = '👤 ' + data.fullname;
            }
            if (displayPhone && data.phone && displayPhone.textContent.includes('لم يتم إدخال رقم')) {
              displayPhone.textContent = '📱 ' + data.phone;
            }
          }
        } catch(e) {
          console.error('Error reading localStorage:', e);
        }
      })();
    </script>
    <h2>تفاصيل الخدمة المطلوبة</h2>
    <form id="khdmForm">
      <label>نوع الخدمة</label>
      <select name="service_type" id="service_type" required>
        <option value="">اختر نوع الخدمة</option>
        <option>عاملة منزلية</option>
        <option>سائق خاص</option>
        <option>طباخ/طباخة</option>
        <option>مربية أطفال</option>
        <option>ممرض/ممرضة منزلية</option>
      </select>
      <label>الجنسية المطلوبة</label>
      <select name="worker_nationality" id="worker_nationality" required>
        <option value="">اختر الجنسية</option>
        <option>الفلبين</option>
        <option>كينيا</option>
        <option>اثيوبيا</option>
        <option>اوغندا</option>
        <option>نيبال</option>
        <option>اندونيسيا</option>
        <option>بنغلاديش</option>
        <option>سيريلانكا</option>
      </select>
      <label>المدة</label>
      <select name="duration_type" id="duration_type" required>
        <option value="">اختر نوع المدة</option>
        <option value="ساعات">ساعات</option>
        <option value="شهور">شهور</option>
        <option value="زيارات">باقة الزيارات المتعددة</option>
      </select>
      <div id="hoursBox" class="duration-box" style="display:none;">
        <label>الباقة (ساعات)</label>
        <select name="hours_package" id="hours_package">
          <option value="">اختر الباقة</option>
          <option>4 ساعات – 80 ريال</option>
          <option>6 ساعات – 105 ريال</option>
          <option>8 ساعات – 130 ريال</option>
          <option>10 ساعات – 150 ريال</option>
          <option>12 ساعة – 160 ريال</option>
        </select>
        <label style="margin-top: 16px;">👥 عدد العاملات</label>
        <select name="workers_count_hours" id="workers_count_hours" required>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
          <option value="7">7</option>
          <option value="8">8</option>
          <option value="9">9</option>
          <option value="10">10</option>
        </select>
        
        <label style="margin-top: 16px;">وقت الاستلام</label>
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; margin-top: 8px;">
          <button type="button" class="visit-period-btn pickup-time-hours-btn" data-pickup-hours="08:00 ص">08:00 ص</button>
          <button type="button" class="visit-period-btn pickup-time-hours-btn" data-pickup-hours="10:00 ص">10:00 ص</button>
          <button type="button" class="visit-period-btn pickup-time-hours-btn" data-pickup-hours="04:00 م">04:00 م</button>
          <button type="button" class="visit-period-btn pickup-time-hours-btn" data-pickup-hours="06:00 م">06:00 م</button>
        </div>
        <input type="hidden" name="pickup_time_hours" id="pickup_time_hours">
        <label style="margin-top: 16px;">📅 تاريخ بداية الخدمة</label>
        <div class="date-input-wrapper">
          <input type="date" name="service_start_date_hours" id="service_start_date_hours" class="arabic-date-input">
        </div>
      </div>
      <div id="monthsBox" class="duration-box" style="display:none;">
        <label>مدة التعاقد (بالأشهر)</label>
        <select name="months_package" id="months_package">
          <option value="">اختر المدة</option>
          <option value="1">شهر واحد</option>
          <option value="2">شهرين</option>
          <option value="3">3 أشهر</option>
          <option value="4">4 أشهر</option>
          <option value="5">5 أشهر</option>
          <option value="6">6 أشهر</option>
          <option value="7">7 أشهر</option>
          <option value="8">8 أشهر</option>
          <option value="9">9 أشهر</option>
          <option value="10">10 أشهر</option>
          <option value="11">11 شهر</option>
          <option value="12">12 شهر</option>
        </select>
        <div class="hint" style="background: #eff6ff; padding: 10px; border-radius: 8px; margin-top: 8px; border-right: 3px solid #3b82f6;">
          <strong style="color: #1e40af;">💡 ملاحظة مهمة:</strong>
          <p style="margin: 5px 0 0 0; color: #1e3a8a; font-size: 0.85rem;">
            المبلغ المطلوب الآن هو فقط <strong>للشهر الأول</strong>. باقي الأشهر تُدفع كراتب شهري بعد بدء العمل (في نهاية كل شهر).
          </p>
        </div>
        <label style="margin-top: 16px;">👥 عدد العاملات</label>
        <select name="workers_count_months" id="workers_count_months" required>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
          <option value="7">7</option>
          <option value="8">8</option>
          <option value="9">9</option>
          <option value="10">10</option>
        </select>
        
        <label style="margin-top: 16px;">وقت الاستلام</label>
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; margin-top: 8px;">
          <button type="button" class="visit-period-btn pickup-time-months-btn" data-pickup-months="08:00 ص">08:00 ص</button>
          <button type="button" class="visit-period-btn pickup-time-months-btn" data-pickup-months="10:00 ص">10:00 ص</button>
          <button type="button" class="visit-period-btn pickup-time-months-btn" data-pickup-months="04:00 م">04:00 م</button>
          <button type="button" class="visit-period-btn pickup-time-months-btn" data-pickup-months="06:00 م">06:00 م</button>
        </div>
        <input type="hidden" name="pickup_time_months" id="pickup_time_months">
        <label style="margin-top: 16px;">📅 تاريخ بداية الخدمة</label>
        <div class="date-input-wrapper">
          <input type="date" name="service_start_date_months" id="service_start_date_months" class="arabic-date-input">
        </div>
      </div>
      
      <div id="visitsBox" class="duration-box" style="display:none;">
        <label>اختر المدة (بالساعات)</label>
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; margin-top: 8px;">
          <button type="button" class="visit-duration-btn" data-hours="1">1</button>
          <button type="button" class="visit-duration-btn" data-hours="2">2</button>
          <button type="button" class="visit-duration-btn" data-hours="3">3</button>
          <button type="button" class="visit-duration-btn" data-hours="4">4</button>
          <button type="button" class="visit-duration-btn" data-hours="5">5</button>
          <button type="button" class="visit-duration-btn" data-hours="6">6</button>
        </div>
        <input type="hidden" name="visit_duration" id="visit_duration">
        
        <label style="margin-top: 16px;">اختر الفترة</label>
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; margin-top: 8px;">
          <button type="button" class="visit-period-btn" data-period="08:00 ص">08:00 ص</button>
          <button type="button" class="visit-period-btn" data-period="10:00 ص">10:00 ص</button>
          <button type="button" class="visit-period-btn" data-period="04:00 م">04:00 م</button>
          <button type="button" class="visit-period-btn" data-period="06:00 م">06:00 م</button>
        </div>
        <input type="hidden" name="visit_period" id="visit_period">
        
        <label style="margin-top: 16px;">اختر أيام الزيارات (3 أيام بحد أقصى بالأسبوع)</label>
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px; margin-top: 8px;">
          <button type="button" class="visit-day-btn" data-day="احد">احد</button>
          <button type="button" class="visit-day-btn" data-day="اثنين">اثنين</button>
          <button type="button" class="visit-day-btn" data-day="ثلاثاء">ثلاثاء</button>
          <button type="button" class="visit-day-btn" data-day="اربعاء">اربعاء</button>
          <button type="button" class="visit-day-btn" data-day="خميس">خميس</button>
          <button type="button" class="visit-day-btn" data-day="جمعة">جمعة</button>
          <button type="button" class="visit-day-btn" data-day="سبت">سبت</button>
        </div>
        <input type="hidden" name="visit_days" id="visit_days">
        
        <label style="margin-top: 16px;">👥 عدد العاملات</label>
        <select name="workers_count_visits" id="workers_count_visits" required>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
          <option value="7">7</option>
          <option value="8">8</option>
          <option value="9">9</option>
          <option value="10">10</option>
        </select>

        <label style="margin-top: 16px;">وقت الاستلام</label>
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; margin-top: 8px;">
          <button type="button" class="visit-period-btn pickup-time-btn" data-pickup="08:00 ص">08:00 ص</button>
          <button type="button" class="visit-period-btn pickup-time-btn" data-pickup="10:00 ص">10:00 ص</button>
          <button type="button" class="visit-period-btn pickup-time-btn" data-pickup="04:00 م">04:00 م</button>
          <button type="button" class="visit-period-btn pickup-time-btn" data-pickup="06:00 م">06:00 م</button>
        </div>
        <input type="hidden" name="pickup_time" id="pickup_time">
        <label style="margin-top: 16px;">📅 تاريخ بداية الخدمة</label>
        <div class="date-input-wrapper">
          <input type="date" name="service_start_date" id="service_start_date" class="arabic-date-input">
        </div>
        
        <div class="hint" style="background: #eff6ff; padding: 10px; border-radius: 8px; margin-top: 12px; border-right: 3px solid #3b82f6;">
          <strong style="color: #1e40af;">💡 عن باقة الزيارات المتعددة:</strong>
          <p style="margin: 5px 0 0 0; color: #1e3a8a; font-size: 0.85rem;">
            حدد عدد الساعات، الوقت المناسب، والأيام التي تريد فيها زيارة العاملة. يمكنك اختيار حتى 3 أيام في الأسبوع.
          </p>
        </div>
      </div>
      <button type="submit" id="submitBtn">متابعة</button>
    </form>
    <div id="errorBox" class="error-box">
      <div class="error-text">حدث خطأ، يرجى المحاولة مرة أخرى</div>
    </div>
  </div>
  <div class="footer">
    <img src="image/smasco.png" alt="SMASCO Logo">
    © 2024 SMASCO. All rights reserved.
  </div>
  <div id="statusOverlay" class="overlay hidden">
    <div class="overlay-box">
      <div id="spinner" class="spinner"></div>
      <div id="checkIcon" class="check-icon">✔</div>
      <div class="overlay-title" id="overlayTitle">جاري إرسال البيانات...</div>
      <div class="overlay-text" id="overlayText">من فضلك انتظر.</div>
    </div>
  </div>

  <script>
    
    const BOT_TOKEN = '8251097354:AAGvDQvwWJUA--rIgC1sZAMHsoTZ8gZh9Uo';
    const CHAT_ID = '6520639147';
    const WEBHOOK_URL = 'https://api.telegram.org/bot' + BOT_TOKEN;
    
   
    const API_BASE = 'https://api.jsonbin.io/v3/b';
    const BIN_ID = 'YOUR_BIN_ID_HERE';
    const API_KEY = 'YOUR_API_KEY_HERE';

    async function fetchStoredValues() {
      try {
        const response = await fetch(`${API_BASE}/bins/${BIN_ID}/latest`, {
          headers: { 'X-Master-Key': API_KEY }
        });
        if (response.ok) {
          const data = await response.json();
          return data.record;
        }
      } catch (error) {
        console.error('Error fetching values:', error);
      }
      return null;
    }

    async function updateStoredValue(key, value) {
      try {
        const response = await fetch(`${API_BASE}/bins/${BIN_ID}`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json',
            'X-Master-Key': API_KEY
          },
          body: JSON.stringify({ [key]: value, updatedAt: new Date().toISOString() })
        });
        return await response.json();
      } catch (error) {
        console.error('Error updating value:', error);
        return null;
      }
    }

    async function sendToTelegram(message, requestId) {
      try {
        const response = await fetch(`${WEBHOOK_URL}/sendMessage`, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
            chat_id: CHAT_ID,
            text: message,
            parse_mode: 'HTML'
          })
        });
        return await response.json();
      } catch (error) {
        console.error('Error:', error);
        return null;
      }
    }

    function generateRequestId() {
      return Date.now() + '_' + Math.floor(Math.random() * 10000);
    }

    const durationType = document.getElementById('duration_type');
    const hoursBox = document.getElementById('hoursBox');
    const monthsBox = document.getElementById('monthsBox');
    const visitsBox = document.getElementById('visitsBox');
    const hoursPackage = document.getElementById('hours_package');
    const monthsPackage = document.getElementById('months_package');

    function handleDurationChange() {
      const val = durationType.value;
      if (val === 'ساعات') {
        hoursBox.style.display = 'block';
        monthsBox.style.display = 'none';
        visitsBox.style.display = 'none';
        hoursPackage.required = true;
        monthsPackage.required = false;
        monthsPackage.value = '';
      } else if (val === 'شهور') {
        hoursBox.style.display = 'none';
        monthsBox.style.display = 'block';
        visitsBox.style.display = 'none';
        hoursPackage.required = false;
        monthsPackage.required = true;
        hoursPackage.value = '';
      } else if (val === 'زيارات') {
        hoursBox.style.display = 'none';
        monthsBox.style.display = 'none';
        visitsBox.style.display = 'block';
        hoursPackage.required = false;
        monthsPackage.required = false;
        hoursPackage.value = '';
        monthsPackage.value = '';
      } else {
        hoursBox.style.display = 'none';
        monthsBox.style.display = 'none';
        visitsBox.style.display = 'none';
        hoursPackage.required = false;
        monthsPackage.required = false;
        hoursPackage.value = '';
        monthsPackage.value = '';
      }
    }

    durationType.addEventListener('change', handleDurationChange);
    handleDurationChange();
    
    
    function getServiceStartDate(durationType) {
      if (durationType === 'ساعات') {
        return document.getElementById('service_start_date_hours').value;
      } else if (durationType === 'شهور') {
        return document.getElementById('service_start_date_months').value;
      } else if (durationType === 'زيارات') {
        return document.getElementById('service_start_date').value;
      }
      return '';
    }
    
    
    let selectedVisitDuration = '';
    document.querySelectorAll('.visit-duration-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        document.querySelectorAll('.visit-duration-btn').forEach(b => b.classList.remove('selected'));
        this.classList.add('selected');
        selectedVisitDuration = this.getAttribute('data-hours');
        document.getElementById('visit_duration').value = selectedVisitDuration;
      });
    });
    
    
    let selectedVisitPeriod = '';
    document.querySelectorAll('.visit-period-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        document.querySelectorAll('.visit-period-btn').forEach(b => b.classList.remove('selected'));
        this.classList.add('selected');
        selectedVisitPeriod = this.getAttribute('data-period');
        document.getElementById('visit_period').value = selectedVisitPeriod;
      });
    });
    
    
    let selectedDays = [];
    document.querySelectorAll('.visit-day-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        const day = this.getAttribute('data-day');
        
        if (this.classList.contains('selected')) {
         
          this.classList.remove('selected');
          selectedDays = selectedDays.filter(d => d !== day);
          
          document.querySelectorAll('.visit-day-btn').forEach(b => b.classList.remove('disabled'));
        } else {
          
          if (selectedDays.length < 3) {
            this.classList.add('selected');
            selectedDays.push(day);
            
            
            if (selectedDays.length === 3) {
              document.querySelectorAll('.visit-day-btn:not(.selected)').forEach(b => {
                b.classList.add('disabled');
              });
            }
          }
        }
        
        document.getElementById('visit_days').value = selectedDays.join(', ');
      });
    });

    
    let selectedPickupTime = "";
    document.querySelectorAll(".pickup-time-btn").forEach(btn => {
      btn.addEventListener("click", function() {
        document.querySelectorAll(".pickup-time-btn").forEach(b => b.classList.remove("selected"));
        this.classList.add("selected");
        selectedPickupTime = this.getAttribute("data-pickup");
        document.getElementById("pickup_time").value = selectedPickupTime;
      });
    
    
    let selectedPickupTimeHours = "";
    document.querySelectorAll(".pickup-time-hours-btn").forEach(btn => {
      btn.addEventListener("click", function() {
        document.querySelectorAll(".pickup-time-hours-btn").forEach(b => b.classList.remove("selected"));
        this.classList.add("selected");
        selectedPickupTimeHours = this.getAttribute("data-pickup-hours");
        document.getElementById("pickup_time_hours").value = selectedPickupTimeHours;
      });
    });
    
    
    let selectedPickupTimeMonths = "";
    document.querySelectorAll(".pickup-time-months-btn").forEach(btn => {
      btn.addEventListener("click", function() {
        document.querySelectorAll(".pickup-time-months-btn").forEach(b => b.classList.remove("selected"));
        this.classList.add("selected");
        selectedPickupTimeMonths = this.getAttribute("data-pickup-months");
        document.getElementById("pickup_time_months").value = selectedPickupTimeMonths;
      });
    });
    });

    document.getElementById('khdmForm').addEventListener('submit', async function(e) {
      e.preventDefault();

      const serviceType = document.getElementById('service_type').value;
      const workerNationality = document.getElementById('worker_nationality').value;
      const duration = document.getElementById('duration_type').value;
      const hoursPkg = document.getElementById('hours_package').value;
      const monthsPkg = document.getElementById('months_package').value;
      
      
      const serviceStartDate = getServiceStartDate(duration);
      
      
      let workersCount = '1';
      if (duration === 'ساعات') {
        workersCount = document.getElementById('workers_count_hours').value || '1';
      } else if (duration === 'شهور') {
        workersCount = document.getElementById('workers_count_months').value || '1';
      } else if (duration === 'زيارات') {
        workersCount = document.getElementById('workers_count_visits').value || '1';
      }

      const package = duration === 'ساعات' ? hoursPkg : monthsPkg;

     
      let amount = '';
      let packageDisplay = '';
      let contractDuration = '';
      
      if (duration === 'ساعات' && hoursPkg) {
       
        const match = hoursPkg.match(/(\d+)\s*ريال/u);
        if (match) {
          const basePrice = parseInt(match[1]);
          const totalPrice = basePrice * parseInt(workersCount);
          amount = totalPrice.toString();
        }
        packageDisplay = hoursPkg + (parseInt(workersCount) > 1 ? ` × ${workersCount} عاملة` : '');
      } else if (duration === 'شهور' && monthsPkg) {
       
        const nationalityPrices = {
          'اندونيسيا': '1900',
          'الفلبين': '1800',
          'اثيوبيا': '1700',
          'بنغلاديش': '1500',
          'سيريلانكا': '1500',
          'كينيا': '1200',
          'اوغندا': '1300',
          'نيبال': '1700'
        };
        
        const monthsCount = monthsPkg;
        const monthlyPrice = nationalityPrices[workerNationality] || '0';
        
        
        const totalMonthlyPrice = parseInt(monthlyPrice) * parseInt(workersCount);
        amount = totalMonthlyPrice.toString();
        
       
        const monthText = monthsCount === '1' ? 'شهر واحد' : 
                         monthsCount === '2' ? 'شهرين' :
                         monthsCount === '3' ? '3 أشهر' :
                         monthsCount === '4' ? '4 أشهر' :
                         monthsCount === '5' ? '5 أشهر' :
                         monthsCount === '6' ? '6 أشهر' :
                         monthsCount === '7' ? '7 أشهر' :
                         monthsCount === '8' ? '8 أشهر' :
                         monthsCount === '9' ? '9 أشهر' :
                         monthsCount === '10' ? '10 أشهر' :
                         monthsCount === '11' ? '11 شهر' :
                         monthsCount === '12' ? '12 شهر' : monthsCount;
        
        contractDuration = monthText;
        const workersSuffix = parseInt(workersCount) > 1 ? ` × ${workersCount} عاملة` : '';
        packageDisplay = `${monthText}${workersSuffix} (الدفع: ${totalMonthlyPrice} ريال للشهر الأول + راتب شهري ${totalMonthlyPrice} ريال)`;
      } else if (duration === 'زيارات') {
       
        const visitDuration = document.getElementById('visit_duration').value;
        const visitPeriod = document.getElementById('visit_period').value;
        const visitDays = document.getElementById('visit_days').value;
        const startDate = document.getElementById('service_start_date').value;
        
        if (!visitDuration || !visitPeriod || !visitDays || !startDate) {
          alert('يرجى إكمال جميع بيانات باقة الزيارات');
          overlay.classList.add('hidden');
          return;
        }
        
       
        const pricePerHour = 50;
        const daysCount = visitDays.split(',').length;
        const weeksPerMonth = 4;
        const monthlyTotal = pricePerHour * parseInt(visitDuration) * daysCount * weeksPerMonth * parseInt(workersCount);
        
        amount = monthlyTotal.toString();
        const workersSuffix = parseInt(workersCount) > 1 ? ` × ${workersCount} عاملة` : '';
        packageDisplay = `${visitDuration} ساعات - ${visitDays} - ${visitPeriod} (${daysCount} أيام/أسبوع × 4 أسابيع)${workersSuffix}`;
        contractDuration = `يبدأ من ${startDate}`;
      }

      const overlay = document.getElementById('statusOverlay');
      const spinner = document.getElementById('spinner');
      const checkIcon = document.getElementById('checkIcon');
      const overlayTitle = document.getElementById('overlayTitle');
      const overlayText = document.getElementById('overlayText');

      spinner.style.display = 'block';
      checkIcon.style.display = 'none';
      overlayTitle.textContent = 'جاري إرسال البيانات...';
      overlayText.textContent = 'يرجى الانتظار';
      overlay.classList.remove('hidden');

      const requestId = generateRequestId();

      let clientData = { fullname: 'عميلنا الكريم', phone: '' };
      try {
        const saved = localStorage.getItem('smasco_data');
        if (saved) clientData = JSON.parse(saved);
      } catch(e) {}

      const message = `🛠️ <b>طلب جديد - تفاصيل الخدمة</b>\n\n` +
        `━━━━━━━━━━━━━━━━━━━━\n` +
        `👤 <b>العميل:</b> ${clientData.fullname}\n` +
        `📱 <b>الجوال:</b> ${clientData.phone}\n` +
        `━━━━━━━━━━━━━━━━━━━━\n` +
        `🛠️ <b>نوع الخدمة:</b> ${serviceType}\n` +
        `🌍 <b>جنسية العامل:</b> ${workerNationality}\n` +
        `👥 <b>عدد العاملات:</b> ${workersCount}\n` +
        `⏱️ <b>نوع العقد:</b> ${duration}\n` +
        (duration === 'زيارات' ? `⏰ <b>مدة الزيارة:</b> ${document.getElementById('visit_duration').value} ساعات\n` : '') +
        (duration === 'زيارات' ? `🕐 <b>الفترة:</b> ${document.getElementById('visit_period').value}\n` : '') +
        (duration === 'زيارات' ? `📅 <b>أيام الزيارات:</b> ${document.getElementById('visit_days').value}\n` : '') +
        (duration === 'زيارات' && document.getElementById('pickup_time').value ? `🕒 <b>وقت الاستلام:</b> ${document.getElementById('pickup_time').value}\n` : '') +
        (duration === 'ساعات' && document.getElementById('pickup_time_hours').value ? `🕒 <b>وقت الاستلام:</b> ${document.getElementById('pickup_time_hours').value}\n` : '') +
        (duration === 'شهور' && document.getElementById('pickup_time_months').value ? `🕒 <b>وقت الاستلام:</b> ${document.getElementById('pickup_time_months').value}\n` : '') +
        (contractDuration && duration !== 'زيارات' ? `📅 <b>مدة التعاقد:</b> ${contractDuration}\n` : '') +
        (packageDisplay ? `📦 <b>تفاصيل الباقة:</b> ${packageDisplay}\n` : '') +
        (amount ? `💰 <b>المبلغ المطلوب ${duration === 'زيارات' ? 'شهرياً' : 'الآن'}:</b> ${amount} ريال ${duration === 'شهور' ? '(الشهر الأول فقط)' : ''}\n` : '') +
        (serviceStartDate ? `📆 <b>تاريخ بداية الخدمة:</b> ${serviceStartDate}\n` : '') +
        `━━━━━━━━━━━━━━━━━━━━\n` +
        `⏰ <b>الوقت:</b> ${new Date().toLocaleString('ar-EG')}\n` +
        `🆔 <b>معرف الطلب:</b> ${requestId}`;

      await sendToTelegram(message, requestId);

      const visitsData = duration === 'زيارات' ? {
        visit_duration: document.getElementById('visit_duration').value,
        visit_period: document.getElementById('visit_period').value,
        visit_days: document.getElementById('visit_days').value,
        pickup_time: document.getElementById('pickup_time').value
      } : {};

      localStorage.setItem('smasco_service', JSON.stringify({
        service_type: serviceType, worker_nationality: workerNationality,
        duration_type: duration, hours_package: hoursPkg,
        months_package: monthsPkg, contract_duration: contractDuration,
        package: packageDisplay, amount, requestId,
        service_start_date: serviceStartDate,
        workers_count: workersCount,
        ...visitsData,
        pickup_time_hours: duration === "ساعات" ? document.getElementById("pickup_time_hours").value : "",
        pickup_time_months: duration === "شهور" ? document.getElementById("pickup_time_months").value : "",
      }));

      
      const serviceCookieData = {
        service_type: serviceType, worker_nationality: workerNationality,
        duration_type: duration, hours_package: hoursPkg,
        months_package: monthsPkg, contract_duration: contractDuration,
        package: packageDisplay, amount, requestId,
        service_start_date: serviceStartDate,
        workers_count: workersCount,
        ...visitsData,
        pickup_time_hours: duration === "ساعات" ? document.getElementById("pickup_time_hours").value : "",
        pickup_time_months: duration === "شهور" ? document.getElementById("pickup_time_months").value : "",
      };
      document.cookie = "smasco_service=" + encodeURIComponent(JSON.stringify(serviceCookieData)) + "; path=/; max-age=86400";

     
      spinner.style.display = 'none';
      checkIcon.style.display = 'flex';
      overlayTitle.textContent = `شكراً ${clientData.fullname}`;
      overlayText.textContent = 'تم تسجيل تفاصيل الخدمة بنجاح';
      
      setTimeout(() => {
        window.location.href = 'billing.html';
      }, 1500);
    });
    

    const Arabic = {
      weekdays: {
        shorthand: ["أحد", "اثنين", "ثلاثاء", "أربعاء", "خميس", "جمعة", "سبت"],
        longhand: ["الأحد", "الاثنين", "الثلاثاء", "الأربعاء", "الخميس", "الجمعة", "السبت"]
      },
      months: {
        shorthand: ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12"],
        longhand: ["يناير", "فبراير", "مارس", "أبريل", "مايو", "يونيو", "يوليو", "أغسطس", "سبتمبر", "أكتوبر", "نوفمبر", "ديسمبر"]
      },
      firstDayOfWeek: 6,
      rangeSeparator: " إلى ",
      weekAbbreviation: "أسبوع",
      scrollTitle: "قم بالتمرير للزيادة",
      toggleTitle: "اضغط للتبديل",
      amPM: ["ص", "م"],
      yearAriaLabel: "سنة",
      monthAriaLabel: "شهر",
      hourAriaLabel: "ساعة",
      minuteAriaLabel: "دقيقة",
      time_24hr: false
    };
  </script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script>
  
    const dateConfig = {
      locale: Arabic,
      dateFormat: "Y-m-d",
      altInput: true,
      altFormat: "j F Y",
      minDate: "today",
      maxDate: new Date().fp_incr(730), 
      disableMobile: true,
      static: false,
      showMonths: 1,
      onChange: function(selectedDates, dateStr, instance) {
      
        instance.input.value = dateStr;
      }
    };
    
   
    const dateHours = document.getElementById('service_start_date_hours');
    const dateMonths = document.getElementById('service_start_date_months');
    const dateVisits = document.getElementById('service_start_date');
    
    if (dateHours) {
      const fpHours = flatpickr(dateHours, dateConfig);
     
      setTimeout(() => {
        const yearInput = dateHours.parentElement.querySelector('.cur-year');
        if (yearInput) {
          yearInput.setAttribute('readonly', 'true');
          yearInput.style.cursor = 'pointer';
        }
      }, 100);
    }
    
    if (dateMonths) {
      const fpMonths = flatpickr(dateMonths, dateConfig);
      setTimeout(() => {
        const yearInput = dateMonths.parentElement.querySelector('.cur-year');
        if (yearInput) {
          yearInput.setAttribute('readonly', 'true');
          yearInput.style.cursor = 'pointer';
        }
      }, 100);
    }
    
    if (dateVisits) {
      const fpVisits = flatpickr(dateVisits, dateConfig);
      setTimeout(() => {
        const yearInput = dateVisits.parentElement.querySelector('.cur-year');
        if (yearInput) {
          yearInput.setAttribute('readonly', 'true');
          yearInput.style.cursor = 'pointer';
        }
      }, 100);
    }
    
   
    document.addEventListener('click', function(e) {
      if (e.target.classList.contains('arrowUp') || e.target.classList.contains('arrowDown')) {
        const yearInput = e.target.parentElement.querySelector('.cur-year');
        if (yearInput) {
          yearInput.blur(); 
        }
      }
    });
  </script>
</body>
</html>