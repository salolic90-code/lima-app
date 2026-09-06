<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proforma N° {{ $proforma->number }} | LimaSport</title>
    <style>
        :root { color: #111; font-family: Arial, Helvetica, sans-serif; }
        * { box-sizing: border-box; }
        body { margin: 0; background: #e8eceb; }
        .toolbar { display: flex; justify-content: flex-end; gap: 10px; max-width: 210mm; margin: 20px auto 12px; }
        .toolbar button { border: 0; border-radius: 7px; padding: 10px 16px; background: #10251e; color: #fff; cursor: pointer; font-weight: 700; }
        .toolbar button.secondary { background: #fff; color: #10251e; border: 1px solid #cbd5d0; }
        .sheet { width: 210mm; min-height: 297mm; margin: 0 auto 24px; padding: 13mm 13mm 16mm; background: #fff; }
        .header { display: flex; align-items: flex-start; justify-content: space-between; border-bottom: 2px solid #10251e; padding-bottom: 10px; }
        .brand { display: flex; align-items: center; gap: 9px; }
        .brand-mark { display: grid; place-items: center; width: 58px; height: 42px; object-fit: contain; }
        .brand-name { color: #111; font-size: 26px; font-weight: 900; letter-spacing: -1.5px; }
        .brand-name span { display: block; color: #555; font-size: 8px; letter-spacing: 2px; text-align: right; }
        .document-title { color: #e21c2a; font-size: 22px; font-weight: 800; }
        .meta { display: grid; grid-template-columns: 1fr 1fr; gap: 22px; margin: 18px 0; font-size: 11px; line-height: 1.45; }
        .meta h3 { margin: 0 0 10px; font-size: 12px; }
        .meta p { margin: 3px 0; }
        .meta strong { display: inline-block; width: 78px; }
        table { width: 100%; border-collapse: collapse; font-size: 10px; }
        th, td { border: 1px solid #111; padding: 7px 6px; vertical-align: top; }
        th { background: #e9eceb; text-align: center; font-size: 9px; }
        .item-row { height: 105px; }
        .center { text-align: center; vertical-align: middle; }
        .description { line-height: 1.35; }
        .bottom { display: flex; justify-content: space-between; align-items: flex-start; margin-top: 48px; font-size: 10px; }
        .payments { width: 125px; }
        .payments strong { display: block; margin-bottom: 4px; }
        .payments div { border: 1px solid #111; padding: 5px; font-weight: 700; }
        .totals { width: 148px; }
        .totals div { display: flex; justify-content: space-between; border: 1px solid #111; border-bottom: 0; padding: 5px 7px; font-weight: 700; }
        .totals div:last-child { border-bottom: 1px solid #111; }
        .signature { margin: 80px auto 0; width: 210px; border-top: 1px solid #111; padding-top: 5px; text-align: center; font-size: 10px; font-weight: 700; }
        @media print { body { background: #fff; } .toolbar { display: none; } .sheet { width: 210mm; min-height: 297mm; margin: 0; padding: 13mm 13mm 16mm; } @page { size: A4; margin: 0; } }
        @media (max-width: 800px) { .sheet { width: 100%; min-height: auto; padding: 24px; } .meta { gap: 12px; } .toolbar { margin: 12px; } }
    </style>
</head>
<body>
    <div class="toolbar"><button class="secondary" type="button" onclick="window.close()">Cerrar</button><button type="button" onclick="window.print()">Imprimir / Guardar PDF</button></div>
    <main class="sheet">
        @php($companyName = $companySettings['business_name'] ?? 'Lima Store')
        @php($companyTaxId = $companySettings['tax_id'] ?? '1500885916001')
        @php($companyAddress = $companySettings['address'] ?? 'Calle Tena y Cuenca')
        @php($companyPhone = $companySettings['phone'] ?? '961754836')
        @php($companyEmail = $companySettings['email'] ?? 'limasport@gmail.com')
        @php($companyLogo = $companySettings['logo'] ?? null)
        <header class="header"><div class="brand">@if($companyLogo)<img class="brand-mark" src="{{ asset('storage/'.$companyLogo) }}" alt="Logo {{ $companyName }}">@else<div class="brand-mark"></div>@endif</div><div class="document-title">PROFORMA N° {{ $proforma->number }}</div></header>
        @php($subtotal = $proforma->quantity * $proforma->unit_price)
        @php($tax = $subtotal * ($proforma->tax_rate / 100))
        <section class="meta"><div><h3>PROFORMAR A:</h3><p><strong>Cliente:</strong> {{ $proforma->client?->name ?? 'Sin cliente' }}</p><p><strong>Ruc/Ci:</strong> {{ $proforma->customer_ruc_ci ?: '-' }}</p><p><strong>Dirección:</strong> {{ $proforma->customer_address ?: '-' }}</p><p><strong>Código:</strong> {{ $proforma->customer_code ?: '-' }}</p><p><strong>Fecha:</strong> {{ $proforma->quote_date?->format('d/m/Y') }}</p><p><strong>Vigencia:</strong> {{ $proforma->validity_days }} Días</p><p><strong>Obj. de Compra:</strong> {{ $proforma->purchase_object ?: '-' }}</p></div><div><h3>&nbsp;</h3><p><strong>Proveedor:</strong> {{ $companyName }}</p><p><strong>Ruc/Ci:</strong> {{ $companyTaxId }}</p><p><strong>Dirección:</strong> {{ $companyAddress }}</p><p><strong>Teléfono:</strong> {{ $companyPhone }}</p><p><strong>Email:</strong> {{ $companyEmail }}</p></div></section>
        <table><thead><tr><th style="width: 6%">ITEM</th><th style="width: 12%">CÓDIGO</th><th>DESCRIPCIÓN DEL PRODUCTO</th><th style="width: 10%">UNIDAD</th><th style="width: 8%">CANT.</th><th style="width: 12%">PRECIO<br>UNITARIO</th><th style="width: 14%">PRECIO GLOBAL</th></tr></thead><tbody><tr class="item-row"><td class="center">1</td><td class="center">{{ $proforma->product_code ?: '-' }}</td><td class="description">{{ $proforma->product_description }}</td><td class="center">{{ $proforma->unit }}</td><td class="center">{{ $proforma->quantity }}</td><td class="center">$ {{ number_format($proforma->unit_price, 2, ',', '.') }}</td><td class="center">$ {{ number_format($subtotal, 2, ',', '.') }}</td></tr><tr class="item-row"><td colspan="7"></td></tr><tr><td colspan="7"></td></tr></tbody></table>
        <section class="bottom"><div class="payments"><strong>Método de pago:</strong><div>{{ $proforma->payment_method }}</div><div>CRÉDITO</div><div>OTROS</div></div><div class="totals"><div><span>SUBTOTAL</span><span>$ {{ number_format($subtotal, 2, ',', '.') }}</span></div><div><span>IVA {{ number_format($proforma->tax_rate, 0) }}%</span><span>$ {{ number_format($tax, 2, ',', '.') }}</span></div><div><span>TOTAL</span><span>$ {{ number_format($proforma->total, 2, ',', '.') }}</span></div></div></section>
        <div class="signature">FIRMA REPRESENTANTE</div>
    </main>
</body>
</html>
