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
            }

    td {
        line-break: anywhere;
    }

    table {
        border-collapse: collapse;
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
    <h1 class="title" style="text-align: center">BÁO CÁO VỀ DANH SÁCH ĐỐI TÁC TẠI SPEEDY</h1>
    <p style="text-align: right">Hà Nội: <?= date("Y-m-d") ?></p>
    <table>
        <thead>
        <tr>
            <th style="width: 10%">
                STT
            </th>
            <th style="width: 15%">
                Mã Đối Tác
            </th>
            <th style="width: 25%">
                Tên Đối Tác
            </th>
            <th style="width: 25%">
                Người Đại Diện
            </th>
            <th style="width: 20%">
                Số Điện Thoại
            </th>
            <th style="width: 20%;overflow-wrap: break-word;word-break: break-all;">
                Địa Chỉ
            </th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($customers as $customer) {
            $temp++;
            ?>
            <tr style="line-height: 1.5">
                <td style="width: 35px"><?= $temp ?></td>
                <td style="width: 125px"><?= $customer->customer_code ?></td>
                <td style="width: 100px"><?= $customer->name ?></td>
                <td style="width: 100px"><?= $customer->surrogate ?></td>
                <td style="width: 102px"><?= $customer->phone ?></td>
                <td style="width: 150px">
                    <?= $customer->address ?>
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