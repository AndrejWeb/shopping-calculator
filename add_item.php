<?php

session_start();

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
{
    if(isset($_POST['token'], $_SESSION['token'], $_SESSION['token_time']))
    {
        if($_POST['token'] == $_SESSION['token'])
        {

                echo '<div class="row item">
                                        <div class="col-md-8"><input type="text" class="form-control" name="item[]" placeholder="Item Description" /></div>
                                        <div class="col-md-3">
                                            <div class="input-group">
                                                <span class="input-group-addon currency c_before"></span>
                                                <input type="text" class="form-control price" name="price[]" placeholder="Price">
                                                <span class="input-group-addon currency c_after"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-1"><img src="images/remove.png" width="32" height="32" class="delete_item" alt="Remove Item" title="Remove Item" /></div>
                                    </div>';
        }
    }
}
