<?php
foreach($modelsList as $src => $models) {
    echo '<ul>' . $src . '</ul>';
    foreach($models as $model) {
        echo '<li><a href="/cms/' . $src . '/' . $model . '" >' . $model . '</a></li>';
    }
}