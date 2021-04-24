<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>スケジュール帳</title>
</head>

<body>
    <h1>スケジュール帳（１．カレンダー）</h1>
    <p>スケジュールを登録する日を選択してください</p>
    <?php
    // 選択された年月を獲得する
    if (isset($_POST["y"])) {
        // 選択された年月を取得する
        $y = intval($_POST["y"]);
        $m = intval($_POST["m"]);
    } else {
        // 現在の年月を取得する
        $ym_now = date("Ym");
        $y = substr($ym_now, 0, 4);
        $m = substr($ym_now, 4, 2);
    }

    // 年月選択リストを表示する
    echo "<form method='POST' action=''>";
    // 年
    echo "<select name='y'>";
    for ($i = $y - 2; $i <= $y + 2; $i++) {
        echo "<option";
        if ($i == $y) {
            echo " selected ";
        }
        echo ">$i</option>";
    }
    echo "</select>年";

    // 月
    echo "<select name='m'>";
    for ($i = 1; $i <= 12; $i++) {
        echo "<option";
        if ($i == $m) {
            echo " selected ";
        }
        echo ">$i</option>";
    }
    echo "</select>月";
    echo "<input type='submit' value='表示' name='sub1'>";
    echo "</form>";
    ?>

    <!-- カレンダーの表示 -->
    <table border="1">
        <tr>
            <td>日</td>
            <td>月</td>
            <td>火</td>
            <td>水</td>
            <td>木</td>
            <td>金</td>
            <td>土</td>
        </tr>
        <tr>
        <?php
        $wd1 = date("w", mktime(0, 0, 0, $m, 1, $y));
        for($i = 1; $i <= $wd1; $i++){
            echo "<td> </td>";
        }

        $d = 1;
        while (checkdate($m, $d, $y)) {
            // 日付のリンクを表示
            $link = "schedule.php?ymd=%04d%02d%02d";
            echo "<td><a href=\"" . sprintf($link, $y, $m, $d) . "\">{$d}</a></td>";

            // 今日が土曜日の場合処理(6の場合)
            if (date("w", mktime(0, 0, 0, $m, $d, $y)) == 6) {
                // 週を終了
                echo "</tr>";
                // 次の週がある場合は行を準備
                if (checkdate($m, $d+1, $y)) {
                    echo "<tr>";
                }
            }
            $d ++;
        }
        // 最後の週の土曜日まで移動
        $wdx = date("w", mktime(0, 0, 0, $m +1, 0, $y));
        for ($i = 1; $i < 7 - $wdx; $i++) {
            echo "<td> </td>";
        }
        ?>
        </tr>
    </table>
</body>

</html>