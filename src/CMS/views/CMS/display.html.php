<script type="text/javascript">
    $("document").ready(function(){
        $("#show").submit(function(){
            var data = {
                "action": "test"
            };
            data = $(this).serialize() + "&" + $.param(data);
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "/ajax_receiver", //Relative or absolute path to response.php file
                data: data,
                success: function(data) {
                    $(".the-return").html(data['success']);
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
<div class="col-sm-8 blog-main">
    <form action="/bills"  id="show" method="post" accept-charset="utf-8">
        <input type="text" name="favorite_beverage" value="" placeholder="Favorite restaurant" />
        <input type="text" name="favorite_restaurant" value="" placeholder="Favorite beverage" />
        <select name="gender">
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select>
        <input type="submit" name="submit" value="Submit form" />
    </form>
</div>
<div class="the-return">
</div>