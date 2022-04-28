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
    <h1 class="title" style="text-align: center">BÁO CÁO VỀ DANH SÁCH NHÂN VIÊN TẠI SPEEDY</h1>
    <p style="text-align: right">Hà Nội: <?= date("Y-m-d") ?></p>
    <table>
        <thead>
        <tr>
            <th style="width: 10%">
                STT
            </th>
            <th style="width: 15%">
                Mã Nhân Viên
            </th>
            <th style="width: 25%">
                Tên Nhân Viên
            </th>
            <th style="width: 25%">
                Chức Vụ
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
        foreach ($staffs as $staff) {
            $temp++;
            ?>
            <tr style="line-height: 1.5">
                <td style="width: 35px"><?= $temp ?></td>
                <td style="width: 125px"><?= $staff->staff_code ?></td>
                <td style="width: 100px"><?= $staff->fullname ?></td>
                <td style="width: 100px"><?= $staff->staffLevelName ?></td>
                <td style="width: 102px"><?= $staff->phone ?></td>
                <td style="width: 150px">
                    <?= $staff->address ?>
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