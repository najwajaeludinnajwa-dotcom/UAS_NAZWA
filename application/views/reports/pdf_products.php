<!DOCTYPE html>
<html>
<head>
    <title>Product Sales Report</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #ffb6c1; padding-bottom: 10px; }
        .logo { font-size: 24px; font-weight: bold; color: #ff91a4; margin-bottom: 5px; }
        .title { font-size: 18px; margin-bottom: 5px; }
        .date { color: #666; margin-bottom: 20px; text-align: right; }
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
    
    <div class="title">Product Sales Report</div>
    <div class="date">Date Generated: <?= date('d M Y, H:i') ?></div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Product Code</th>
                <th>Product Name</th>
                <th class="text-center">Total Sold</th>
                <th class="text-end">Total Revenue</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; $grand_total = 0; foreach($report_data as $row): $grand_total += ($row->total_revenue ? $row->total_revenue : 0); ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row->product_code ?></td>
                    <td><?= $row->product_name ?></td>
                    <td class="text-center"><?= $row->total_sold ? $row->total_sold : 0 ?></td>
                    <td class="text-end">Rp <?= number_format($row->total_revenue ? $row->total_revenue : 0, 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="text-end"><b>Total All Revenue:</b></td>
                <td class="text-end"><b>Rp <?= number_format($grand_total, 0, ',', '.') ?></b></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
