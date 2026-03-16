<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Payment Receipt - {{ $payment->id }}</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet"/>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }

    html, body {
      width: 100%;
      height: 100%;
      background: #2b2b2b;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 30px 20px;
font-family: Arial, Helvetica, sans-serif;
    }

    /* A4 = 794px × 1123px */
    .receipt-wrapper {
        width: 210mm;
        min-height: 297mm;
        background: #f5f0e8;
        position: relative;
    }

    /* ── BLOBS ── */
    .blob { position: absolute; pointer-events: none; z-index: 0; }
    .blob-1 {
      width: 320px; height: 320px; opacity: 0.12;
      background: #c8b97a;
      bottom: 60px; left: -90px;
      border-radius: 60% 40% 70% 30% / 50% 60% 40% 50%;
    }
    .blob-2 {
      width: 240px; height: 240px; opacity: 0.12;
      background: #c8b97a;
      top: 50px; right: -55px;
      border-radius: 40% 60% 30% 70% / 60% 40% 60% 40%;
    }

    .receipt-header, .info-row, .table-section,
    .spacer, .bottom-section, .receipt-footer {
      position: relative; z-index: 1;
    }

    /* ── HEADER ── */
    .receipt-header {
      padding: 30px 52px 26px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-bottom: 2px solid #d0c8b4;
      flex-shrink: 0;
    }
    .header-left {
      display: flex;
      align-items: center;
      gap: 18px;
    }
    .logo-box {
      width: 80px; height: 80px;
      border-radius: 10px;
      overflow: hidden;
      flex-shrink: 0;
      border: 2px solid #d0c8b4;
      background: #fff;
      display: flex; align-items: center; justify-content: center;
    }
    .logo-box img {
      width: 100%; height: 100%;
      object-fit: contain;
    }
    /* fallback icon when no logo image */
    .logo-icon-fallback {
      width: 72px; height: 72px;
      background: #1a1a1a;
      border-radius: 10px;
      display: flex; align-items: center; justify-content: center;
      flex-shrink: 0;
    }
    .header-title {
      font-family: Arial, Helvetica, sans-serif;
      font-size: 28px; font-weight: 800;
      letter-spacing: .06em; color: #2792fd; line-height: 1.1;
    }
    .header-title-2 {
      font-family: Arial, Helvetica, sans-serif;
      font-size: 20px; font-weight: 800;
      letter-spacing: .06em; color: #2792fd; line-height: 1.1;
    }
    .header-address { font-size: 13px; color: #7a7060; margin-top: 5px; }

    /* receipt number badge on right */
    .header-right { text-align: right; }
    .receipt-badge {
      display: inline-block;
      background: #2792fd;
      color: #fff;
      font-family: Arial, Helvetica, sans-serif;
      font-size: 10px;
      font-weight: 700;
      letter-spacing: .1em;
      text-transform: uppercase;
      padding: 5px 14px;
      border-radius: 100px;
      margin-bottom: 6px;
    }
    .receipt-num {
      font-family: Arial, Helvetica, sans-serif;
      font-size: 18px; font-weight: 800;
      color: #1a1a1a; letter-spacing: .04em;
    }

    /* ── INFO ROW ── */
    .info-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      padding: 18px 52px;
      border-bottom: 2px solid #d0c8b4;
      row-gap: 7px;
      flex-shrink: 0;
    }
    .info-item { font-size: 13px; color: #2e2a22; font-weight: 600; }
    .info-item .val { font-weight: 400; color: #5a5246; }
    .info-item.right { text-align: right; }

    /* ── COMPLAINT DETAIL STRIP ── */
    .complaint-strip {
      display: flex;
      align-items: stretch;
      padding: 14px 52px;
      background: rgba(200,185,122,0.10);
      border-bottom: 2px solid #d0c8b4;
      gap: 32px;
      flex-shrink: 0;
    }
    .cs-item { flex: 1; }
    .cs-label {
      font-family: Arial, Helvetica, sans-serif;
      font-size: 9.5px; font-weight: 700;
      letter-spacing: .12em; text-transform: uppercase;
      color: #7a7060; margin-bottom: 4px;
    }
    .cs-value { font-size: 12.5px; color: #2e2a22; font-weight: 600; }
    .cs-divider { width: 1px; background: #d0c8b4; flex-shrink: 0; }

    /* status + priority badges */
    .badge {
      display: inline-block;
      padding: 2px 10px; border-radius: 100px;
      font-size: 10.5px; font-weight: 700;
      letter-spacing: .04em; text-transform: uppercase;
    }
    .badge-open     { background: #fef9c3; color: #854d0e; }
    .badge-resolved { background: #dcfce7; color: #166534; }
    .badge-closed   { background: #fee2e2; color: #991b1b; }
    .badge-high     { background: #fce7f3; color: #9d174d; }
    .badge-medium   { background: #fef3c7; color: #92400e; }
    .badge-low      { background: #dbeafe; color: #1e40af; }

    /* ── TABLE ── */
    .table-section { padding: 22px 52px 0; flex-shrink: 0; }
    table { width: 100%; border-collapse: collapse; table-layout: fixed; }
    col.col-desc  { width: 46%; }
    col.col-qty   { width: 12%; }
    col.col-price { width: 22%; }
    col.col-total { width: 20%; }

    thead tr { background: #2792fd; }
    thead th {
      font-family: Arial, Helvetica, sans-serif;
      font-size: 10.5px; font-weight: 700;
      letter-spacing: .14em; text-transform: uppercase;
      padding: 12px 12px; color: #fff; text-align: left;
    }
    thead th.center { text-align: center; }
    thead th.right  { text-align: right; }

    tbody tr { border-bottom: 1px solid #d0c8b4; }
    tbody tr:last-child { border-bottom: none; }
    tbody td {
      font-size: 12.5px; color: #2e2a22;
      padding: 13px 12px; text-align: left; vertical-align: middle;
    }
    tbody td.center { text-align: center; }
    tbody td.right  { text-align: right; font-weight: 600; }
    tbody tr.empty-row td { height: 42px; }


    /* ── BOTTOM ── */
    .bottom-section {
      display: grid;
      grid-template-columns: 1fr 1fr;
      padding: 22px 52px 18px;
      gap: 16px;
      border-top: 2px solid #d0c8b4;
      align-items: start;
      flex-shrink: 0;
    }
    .payment-info p {
      font-size: 12.5px; color: #2e2a22;
      margin-bottom: 6px; line-height: 1.6;
    }
    .payment-info strong {
      font-family: Arial, Helvetica, sans-serif;
      font-weight: 700; font-size: 11px;
    }
    .totals-row {
      display: flex; justify-content: space-between;
      font-size: 13px; color: #2e2a22; margin-bottom: 6px;
    }
    .totals-row strong {
      font-family: Arial, Helvetica, sans-serif;
      font-weight: 700; font-size: 11px; letter-spacing: .03em;
    }
    .totals-row.final {
      margin-top: 8px; padding-top: 8px;
      border-top: 2px solid #2e2a22;
      font-family: Arial, Helvetica, sans-serif;
      font-weight: 800; font-size: 15px;
    }

    /* ── FOOTER ── */
.receipt-footer {
    position: absolute;
    bottom: 30mm;
    left: 20mm;
    right: 20mm;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 16px;
    border-top: 1px dashed #d0c8b4;
    padding-top: 16px;
}
    .footer-ids {
      font-size: 10px; color: #aaa09a;
      margin-top: 8px; font-style: italic;
    }
    .sig-label { font-size: 11px; color: #5a5246; margin-bottom: 5px; text-align: center; }
    .sig-svg { display: block; }

.footer-note {
  font-size: 11px;
  color: #7a7060;
  line-height: 1.7;
  max-width: 70%;
}

.signature-block {
  width: 30%;
  text-align: center;
}
.sig-label {
  font-size: 11px;
  color: #5a5246;
  margin-bottom: 6px;
  text-align: center;
}

.stamp-box {
  width: 140px;
  height: 90px;
  border: 1.5px dashed #b0a898;
  border-radius: 6px;
  margin: 6px auto 0;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: flex-end;
  padding-bottom: 8px;
}

.stamp-line {
  width: 110px;
  border-top: 1.5px solid #1a1a1a;
  margin-bottom: 5px;
}

.stamp-text {
  font-size: 9px;
  color: #b0a898;
  letter-spacing: .08em;
  text-transform: uppercase;
  font-family: 'Montserrat', sans-serif;
  font-weight: 600;
}

    /* ── PRINT ── */
    @media print {
      html, body {
        background: white;
        padding: 0; margin: 0;
        display: block;
        width: 210mm; height: 297mm;
      }
      .receipt-wrapper {
    width: 210mm;
    height: 297mm;
    background: #f5f0e8;
    position: relative;
    padding-bottom: 140px; /* reserve space for footer */
}
    }
    @page {
  size: A4;
  margin: 0;
}

html, body {
  width: 210mm;
  height: auto;
  background: white;
  margin: 0;
  padding: 0;
}
  </style>
</head>
<body>

<div class="receipt-wrapper">
  <div class="blob blob-1"></div>
  <div class="blob blob-2"></div>

  {{-- ═══════════════════════════════════════
       HEADER
  ═══════════════════════════════════════ --}}
  <div class="receipt-header">
    <div class="header-left">

      {{-- LOGO: show org/app logo if exists, else fallback icon --}}
      @php
        $logoPath = public_path('images/sk_logo.jpeg');
      @endphp


    <div class="logo-box">
        <img src="{{ public_path('images/sk_logo.jpeg') }}" alt="Safety Logo">
    </div>

      <div>
        <div class="header-title">SHREE S.K.FIRE</div>
        <div class="header-title-2">PAYMENT RECEIPT</div>
        <div class="header-address">Office No.2, Near Raja Oil Mil, Vadi Plot, (PORBANDAR) City - 360575, Gujarat.</div>
      </div>
    </div>

    <div class="header-right">
      <div class="receipt-badge">Official Receipt</div>
      <div class="receipt-num">{{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}</div>
    </div>
  </div>

  {{-- ═══════════════════════════════════════
       INFO ROW  (payment + user data)
  ═══════════════════════════════════════ --}}
  <div class="info-row">
    <div class="info-item">
      Receipt No :
      <span class="val">{{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}</span>
    </div>
    <div class="info-item right">
      Payment Date :
      <span class="val">{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</span>
    </div>
    <div class="info-item">
      Billed To :
      <span class="val">{{ $payment->payment_made_by }}</span>
    </div>
    <div class="info-item right">
      Complaint ID :
      <span class="val">{{ str_pad($complaint->id, 4, '0', STR_PAD_LEFT) }}</span>
    </div>
  </div>

  {{-- ═══════════════════════════════════════
       TABLE
  ═══════════════════════════════════════ --}}
  <div class="table-section">
    <table>
      <colgroup>
        <col class="col-desc"/>
        <col class="col-qty"/>
        <col class="col-price"/>
        <col class="col-total"/>
      </colgroup>
      <thead>
        <tr>
          <th>Description</th>
          <th class="center">QTY</th>
          <th class="center">Unit Price</th>
          <th class="right">Total</th>
        </tr>
      </thead>
      <tbody>
        {{-- Main complaint line item --}}
        <tr>
          <td>{{ $complaint->title }}</td>
          <td class="center">1</td>
          <td class="center">₹{{ number_format($payment->amount, 2) }}</td>
          <td class="right">₹{{ number_format($payment->amount, 2) }}</td>
        </tr>
        {{-- Optional: description as a sub-row --}}
        @if($complaint->description)
        <tr>
          <td colspan="4" style="font-size:11.5px; color:#7a7060; padding: 6px 12px 10px; font-style:italic;">
            {{ Str::limit($complaint->description, 180) }}
          </td>
        </tr>
        @endif
      </tbody>
    </table>
  </div>

  {{-- ═══════════════════════════════════════
       BOTTOM  (payment info + totals)
  ═══════════════════════════════════════ --}}
  <div class="bottom-section">
    <div class="payment-info">
    </div>
    <div class="totals">
      <div class="totals-row">
        <strong>SUBTOTAL :</strong>
        <span>₹{{ number_format($payment->amount, 2) }}</span>
      </div>
      <div class="totals-row">
        <strong>DISCOUNT :</strong>
        <span>₹0.00</span>
      </div>
      <div class="totals-row final">
        <strong>TOTAL :</strong>
        <span>₹{{ number_format($payment->amount, 2) }}</span>
      </div>
    </div>
  </div>

  {{-- ═══════════════════════════════════════
       FOOTER
  ═══════════════════════════════════════ --}}
  <div class="receipt-footer">
    <div>
      <p class="footer-note">
        This receipt is made as proof that a certain amount of money has been received from the relevant party . Please retain this receipt for your records.
      </p>
    </div>
    <div>
    <div class="signature-block">
        <div class="sig-label">Regards</div>
        <div class="stamp-box">
            <div class="stamp-line"></div>
            <div class="stamp-text">Signature & Stamp</div>
        </div>
  </div>

</div>

</body>
</html>
