<?php
$temp = 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    table, td, th {
        border: 1px solid black;
        padding: 5px;
        overflow-wrap: break-word;

    }

    td {
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        word-wrap: break-word;
    }

    table {
        border-collapse: collapse;
        width: auto;
        text-align: center;
        table-layout: fixed;
    }

    .float {
        text-align: center;
        position: absolute;
        right: 0px;
        bottom: -100px;
    }
</style>

<body style="font-family: freeserif">
<form>
    <div style="line-height: 0.1;text-align: center" class="national-name">
        <p style="font-size: 13px">Cộng Hòa Xã Hội Chủ Nghĩa Việt Nam</p>
        <p style="font-size: 14px">Độc Lập -Tự Do - Hạnh Phúc</p>
    </div>
    <h1 class="title" style="text-align: center">BÁO CÁO VỀ LỊCH SẮP XẾP TRẢ KẾT QUẢ SỰ KIỆN: <?= $event->name ?></h1>
    <p style="text-align: right">Hà Nội: <?= date("Y-m-d") ?></p>
    <table>
        <thead>
        <tr>
            <th style="width: 10%">
                STT
            </th>
            <th style="width: 15%">
                Tên K.Hàng
            </th>
            <th style="width: 25%">
                SĐT K.Hàng
            </th>
            <th style="width: 25%">
                Doanh Thu
            </th>
            <th style="width: 20%">
                Đối Tác
            </th>
            <th style="width: 20%;overflow-wrap: break-word;word-break: break-all;">
                Người Trả Kết Quả
            </th>
            <th style="width: 20%;overflow-wrap: break-word;word-break: break-all;">
                Trạng Thái
            </th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($eventResults as $eventResult) {
            $temp++;
            ?>
            <tr style="line-height: 1.5">
                <td style="width: 15px"><?= $temp ?></td>
                <td style="width: 100px"><?= $eventResult->buyer_name ?></td>
                <td style="width: 100px"><?= $eventResult->buyer_phone ?></td>
                <td style="width: 100px"><?= $eventResult->turnover ?></td>
                <td style="width: 102px"><?= $eventResult->customer->name ?></td>
                <td style="width: 60px">
                    <?= $eventResult->seller->fullname ?>
                </td>
                <td style="width: 40px">
                    <?= $eventResult->statusText?>
                </td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
    <div style="position: relative">
        <div class="float">
            <p>Giám Đốc Nhân Sự</p>
            <span>(Ký tên đóng dấu)</span>
        </div>
    </div>
</form>
</body>

</html>