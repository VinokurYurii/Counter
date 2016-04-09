<div class="col-sm-8 blog-main">
    <div>
        <a href="/bill_type/add/0"><button>Добавить вид расхода</button></a>
    </div>
    <br/>
    <?php
    $mainSum = 0;
    foreach ($bills as $bill) { ?>
    <a href="/bill_type/<?php echo $bill->id; ?>" style="color: red">
        <?php echo $bill->type; ?></a>: <strong><?php echo isset($bill->sum) ? $bill->sum : 0; ?></strong>
        <?php if(isset($bill->sum)) { $mainSum += $bill->sum; } ?>
    <?php $walkOnBills($bill); } ?>
    <div>
        <strong>Баланс: <?php echo $mainSum; ?></strong>
    </div>
</div>
<div class="col-sm-8 blog-main">
    <form action="/ajax_receiver"  id="show" method="post" accept-charset="utf-8">
        <input type="text" name="favorite_beverage" value="" placeholder="Favorite restaurant" />
        <input type="text" name="favorite_restaurant" value="" placeholder="Favorite beverage" />
        <select name="gender">
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select>
        <input type="submit" name="submit" value="Submit form" />
    </form>
</div>
<div class=".the-return">
</div>
<script type="text/javascript">
    $("document").ready(function(){
        $("#show").submit(function(){
            var data = {
                "action": "test"
            };
            data = $(this).serialize() + "&" + $.param(data);
            $.ajax({
                type: "POST",
                //dataType: "json",
                url: "/ajax_receiver", //Relative or absolute path to response.php file
                data: data,
                success: function(data) {
                    $(".the-return").html(data.responseText/*
                        "Favorite beverage: " + data["favorite_beverage"] + "<br />Favorite restaurant: " +
                        data["favorite_restaurant"] + "<br />Gender: " + data["gender"] + "<br />JSON: " + data["json"]*/
                    );
                    console.log(data);
                },
                error :	function(xhr, textStatus, errorObj){
                    alert('Произошла критическая ошибка!');console.log(xhr.responseText);console.log(textStatus+' => '+errorObj);
                }
            });
            return false;
        });
    });
</script>