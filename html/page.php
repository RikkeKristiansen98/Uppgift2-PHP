 <?php
        include_once('functions.php');
    ?>
    <?php
    $title = "My page";
        include('header.php');
      ?>
<html>
    <body>
        <?php
        $greeting = "Hello ";

        $name = get_name('Rikke ');

        echo($greeting.$name);

        $list = array(
            array("type" => "ananas "),
            "banan ",
            "citron"
        );

        foreach($list as $item) {
include('listitem.php');
        }
        ?>
    </body>
        </html>
        <?php
        include_once('footer.php');
      ?>