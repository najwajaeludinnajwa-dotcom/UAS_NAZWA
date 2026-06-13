<!DOCTYPE html>
<html>
<head>
    <title>Report By Period</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #ffb6c1; padding-bottom: 10px; }
        .logo { font-size: 24px; font-weight: bold; color: #ff91a4; margin-bottom: 5px; }
        .title { font-size: 18px; margin-bottom: 5px; }
        .date { color: #666; margin-bottom: 20px; text-align: right; }
        .period-info { margin-bottom: 10px; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #fcf5ee; color: #4a4a4a; font-weight: bold; }
        .text-center { text-align: center; }
        .text-end { text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">Glow Beauty</div>
        <div>Sales Order System</div>
    </div>
    
    <div class="title">Report By Period</div>
    <div class="period-info">Period: <?= date('d M Y', strtotime($start_date)) ?> to <?= date('d M Y', strtotime($end_date)) ?></div>
    <div class="date">Date Generated: <?= date('d M Y, H:i') ?></div>

    <table>
        <thead>
            <tr>
                <th>Invoice</th>
                <th>Date</th>
                <th>Member</th>
                <th>Sales Person</th>
                <th>Status</th>
                <th class="text-end">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $grand_total = 0; foreach($report_data as $row): $grand_total += $row->grand_total; ?>
                <tr>
                    <td><?= $row->invoice_number ?></td>
                    <td><?= date('d M Y', strtotime($row->order_date)) ?></td>
                    <td><?= $row->member_name ?></td>
                    <td><?= $row->sales_name ?></td>
                    <td><?= $row->order_status ?></td>
                    <td class="text-end">Rp <?= number_format($row->grand_total, 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
            <?php if(empty($report_data)): ?>
                <tr>
                    <td colspan="6" class="text-center">No transactions found for this period.</td>
                </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" class="text-end"><b>Total Revenue:</b></td>
                <td class="text-end"><b>Rp <?= number_format($grand_total, 0, ',', '.') ?></b></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
