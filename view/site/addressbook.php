<div class="container" style="width:500px;">
    <input type="text" name="name" id="name" class="form-control" placeholder="Search contacts" />

    <div id="nameList">
    </div>
</div>


<?php

echo '<div class="col-md-7 col-md-offset-2"><h3>Contacts</h3><br>';

    if (empty($data)) {
        echo 'You dont have any contact yet';
    } else {
        echo '<p>'.$listing_info.'</p>';
        echo '<ul>';
        foreach ($data as $key => $value) {
            echo "<li class='list-group-item'><a class='link' href='index.php?r=site/contact&id=".$value['id']."'>".ucwords($value['first_name']).' '. ucwords($value['last_name'])."</a></li>";
        }

        echo '</ul>';

        echo '<ul class="pagination">';
        if ($pages >= 1) {
            for ($i = 0; $i <= $pages; $i++) {
                echo "<li".($i == $page ? ' class="active"': "")."><a href='index.php?page=" . $i . "'>" . ($i + 1) . "</a></li>";
            }
        }

        echo '</ul>';
    }
echo '</div>';
?>


    <!--JQUERY SCRIPT FOR SEARCHING -->

    <script>
        $(document).ready(function() {
            $('#name').keyup(function() {
                var query = $(this).val();
                if (query != '') {
                    $.ajax({
                        url: "index.php?r=site/search",
                        method: "POST",
                        data: {
                            query: query
                        },
                        success: function(data) {
                            $('#nameList').fadeIn();
                            $('#nameList').html(data);
                        }
                    });
                }
            });

            $(document).on('click', 'li', function() {
                $('#name').val($(this).text());
                $('#nameList').fadeOut();
            });
        });

    </script>
