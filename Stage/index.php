<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Title</title>
        <script src="include/jquery.min.js" ></script>
        <script src="include/jquery-ui.min.js" ></script>
        <link rel="stylesheet" href="include/bootstrap.css">
        <link rel="stylesheet" href="include/jquery-ui.css">
    </head>
    <body>
    <div class="container p-3">
        <div class="form-group">
            <form id="form_01">
                <table class="table">
                    <tr>
                        <td class="w-25"><input type="text" id="pro_id" placeholder="Project ID" class="form-control" disabled></td>
                        <td class="w-75"><input type="text" id="pro_name" placeholder="Project Name" class="form-control"></td>
                    </tr>
                </table>
            </form>
            <form id="form_02">
                <!-- ===============================================  model form start  ======================================================== -->
                <div class="border rounded p-1">
                    <table class="table table-borderless">
                        <tr>
                            <td class="w-75"><input id="stage_name" type="text" class="form-control" placeholder="Stage Name"></td>
                            <td class="w-25"><input id="approx_budget" type="text" class="form-control" placeholder="Approximate Budget" disabled></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <textarea id="desc" type="text" class="form-control" placeholder="Description"></textarea>
                            </td>
                        </tr>
                    </table>
                    <div class="border rounded">
                        <table class="table table-borderless" id="item_table">
                            <tr>
                                <td><input id="item_id" type="text" class="form-control" placeholder="Item ID" disabled></td>
                                <td><input id="item_name" type="text" class="form-control" placeholder="Item Name"></td>
                                <td><input id="uom" type="text" class="form-control" placeholder="UoM"></td>
                                <td><input id="unit_cost" name="sumField" type="text" class="form-control" placeholder="Unit Cost"></td>
                                <td><input id="qty" type="text" name="sumField" class="form-control" placeholder="Qty"></td>
                                <td><input id="total_amount" type="text" class="form-control" placeholder="Total Amount" disabled></td>
                                <td><input id="add_items" type="button" class="btn btn-outline-success" value="+"></td>
                            </tr>
                        </table>
                        <table id="dynamic_item_table" class="table border-bottom border-top">
                        </table>
                    </div>
                    <button id="submit" type="button" class="btn btn-success mt-2 mb-2">Submit</button>
                </div>
                <!-- ===============================================  model form end  ======================================================== -->
            </form>
            <div id="container" class="border rounded p-1">
            </div>
        </div>
    </div>
    </body>
    <script type="text/javascript" src="fieldCentraler.js"></script>
    <script type="text/javascript" src="searchController.js"></script>
</html>