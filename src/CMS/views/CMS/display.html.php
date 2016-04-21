<div class="the-return">
</div>
<script type="text/javascript">
    
    function IsJsonString(str) {
        try {
            JSON.parse(str);
        } catch (e) {
            return false;
        }
        return true;
    }

    function myOwnF(data) {
        var objectArray = JSON.parse(data[0]);

        var needlessData = [];
        for(var i = 0; i < objectArray.length; i++) {
            needlessData[i] = JSON.parse(objectArray[i]);
        }

        var keysArr = Object.keys(needlessData[0]);

        var html  = '<table cellspacing="2" border="2" align="center"><tr>';

        for(var i = 0; i < keysArr.length; i++) {
            html += '<th>' + keysArr[i] + '</th>';
        }

        html += '</tr>';

        for(var i = 0; i < needlessData.length; i++) {
            html += '<tr>';
            for(var j = 0; j < keysArr.length; j++) {
                html += '<td align="center">' + needlessData[i][keysArr[j]] + '</td>';
            }
            html += '</tr>';
        }
        html += '</table>';
        return html;
    }

    $("document").ready(function(){

        var data = {
            "action": "getModel",
            'model':  window.location.href
        };
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "/ajax_receiver", //Relative or absolute path to response.php file
            data: data,
            success: function(data) {
                $(".the-return").html(myOwnF(data));
            },
            error :	function(xhr, textStatus, errorObj){
                alert('Произошла критическая ошибка initial query!');console.log(xhr.responseText);console.log(textStatus+' => '+errorObj);
            }
        });



        $("#show").submit(function(){
            var data = {
                "action": "getModel",
                'model':  window.location.href
            };
            //data = $(this).serialize() + "&" + $.param(data);
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "/ajax_receiver", //Relative or absolute path to response.php file
                data: data,
                success: function(data) {
                    $(".the-return").html(myOwnF(data));
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
    <form action="/cms/Accounter/BillType"  id="show" method="post" accept-charset="utf-8">
        <input type="text" name="favorite_beverage" value="" placeholder="Favorite restaurant" />
        <input type="text" name="favorite_restaurant" value="" placeholder="Favorite beverage" />
        <select name="gender">
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select>
        <input type="submit" name="submit" value="Submit form" />
    </form>
</div>
<div>
    <script>
    </script>
</div>