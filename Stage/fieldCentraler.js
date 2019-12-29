$(document).ready(function () {
    var item_row_id = 0;
    var data_set = [];
    var status = false;
    var approx_total = 0;
    var display_item_table = 0;
    var validate_status = null;

    // =============================================== js model from start ============================================================
    $('#add_items').click(function () {
        validate_status = true;
        var pro_id = $('#pro_id').val();
        var pro_name = $('#pro_name').val();
        var stage_name = $('#stage_name').val();
        var desc = $('#desc').val();

        var item_id = $('#item_id').val();
        var item_name = $('#item_name').val();
        var uom = $('#uom').val();
        var unit_cost = $('#unit_cost').val();
        var qty = $('#qty').val();
        var total_amount = unit_cost * qty;

        if (pro_name === ""){ validate_status = false; addClassWarning("pro_name"); } else {removeClassWarning("pro_name")}
        if (stage_name === ""){ validate_status = false; addClassWarning("stage_name"); } else {removeClassWarning("pro_name")}
        if (desc === ""){ validate_status = false; addClassWarning("desc"); } else {removeClassWarning("desc")}

        if (item_name === ""){ validate_status = false; addClassWarning("item_name"); } else {removeClassWarning("item_name")}
        if (unit_cost === ""){ validate_status = false; addClassWarning("unit_cost"); } else {removeClassWarning("unit_cost")}
        if (qty === ""){ validate_status = false; addClassWarning("qty"); } else {removeClassWarning("qty")}

        if (true === validate_status) {

            item_row_id++;
            status = false;
            approx_total += total_amount;

            if (data_set.length > 0) {
                for (var i = 0; i < data_set.length; i++) {
                    if (data_set[i].type.includes("master")) {
                        status = true;
                    }
                }
            }

            if (status === false) {
                var master_set = {
                    'type': 'master',
                    'pro_id': pro_id,
                    'stage_name': stage_name,
                    'approx_budget': "",
                    'desc': desc
                };
                data_set.push(master_set);
            }

            for (var y = 0; y < data_set.length; y++) {
                if (data_set[y]['type'].includes('master')) {
                    data_set[y]['approx_budget'] = approx_total;
                }
            }

            var sub = {
                'type': 'item',
                'item_id': item_id,
                'unit_cost': unit_cost,
                'qty': qty,
                'total_amount': total_amount
            };
            data_set.push(sub);

            console.log("Add dataset +++ ");
            console.log(data_set);

            $('#dynamic_item_table').append('<tr id="item_row_' + item_row_id + '">' +
                '<td><input type="text" id="item_id_' + item_row_id + '" class="form-control" value="' + item_id + '" disabled></td>' +
                '<td><input type="text" id="item_name_' + item_row_id + '" class="form-control" value="' + item_name + '" disabled></td>' +
                '<td><input type="text" id="uom_' + item_row_id + '" class="form-control" value="' + uom + '" disabled></td>' +
                '<td><input type="text" id="unit_cost_' + item_row_id + '" class="form-control" value="' + unit_cost + '" disabled></td>' +
                '<td><input type="text" id="qty_' + item_row_id + '" class="form-control" value="' + qty + '" disabled></td>' +
                '<td><input type="text" id="total_amount_' + item_row_id + '" class="form-control" value="' + total_amount + '" disabled></td>' +
                '<td><input type="button" id="' + item_row_id + '" class="btn btn-outline-danger btn-item-remove" value="-"></td>' +
                '</tr>');

            $('#approx_budget').val(approx_total);

            $('#item_id').val("");
            $('#item_name').val("");
            $('#uom').val("");
            $('#unit_cost').val("");
            $('#qty').val("");
            $('#total_amount').val("");
        }
    });
    // remove item field and from dataset array
    $(document).on('click','.btn-item-remove',function () {
        var btn_item_id = $(this).attr("id");
        idss = $('#item_id_'+btn_item_id+'').val();
        for (var i = 0; i < data_set.length; i++){
            if (data_set[i]['type'].includes('item')){
                if (data_set[i]['item_id'].includes(idss)){
                    approx_total -= data_set[i]['total_amount'];
                    data_set.splice(i,1);
                }
            }
        }
        for (var y = 0; y < data_set.length; y++) {
            if (data_set[y]['type'].includes('master')) {
                data_set[y]['approx_budget'] = approx_total;
            }
        }
        console.log("Remove dataset --- ");
        console.log(data_set);
        $('#item_row_'+btn_item_id+'').remove();

    });
    $('input').change(function () {
        var unitCost = parseInt($('#unit_cost').val());
        var qty = parseInt($('#qty').val());
        var totalCost = unitCost * qty;

        $('#total_amount').val(totalCost);
    });
    // =============================================== js model from end ============================================================
    $('#submit').click(function () {
        if (validate_status === true){
            $.ajax({
                url: "stage_stored.php",
                type: "post",
                async: false,
                data: {
                    'dataset': data_set
                },
                success: function (data) {
                    var ttt = JSON.parse(data);
                    if (ttt['state'].includes("OK")){
                        displayDataSet();
                        reset_variables();
                        disabledInputField();
                    }
                }
            });
        }
    });

    function addClassWarning(id) {
        $('#'+id+'').addClass("border-danger");
    }

    function removeClassWarning(id) {
       $('#'+id+'').hasClass("border-danger", function () {
           $(this).removeClass("border-danger");
       });
    }

    function disabledInputField() {
        $('#pro_name'). prop("disabled", true);
    }

    function reset_variables() {
        item_row_id = 0;
        data_set = [];
        status = false;
        approx_total = 0;
        $('#form_02').trigger('reset');
        $('#dynamic_item_table tr').remove();
        validate_status = true;
    }

    function displayDataSet() {
        display_item_table++;
        $('#container').append('<table class="table table-borderless">' +
            '<tr><td class="w-75"><input type="text" class="form-control" value="'+$('#stage_name').val()+'" disabled></td><td class="w-25"><input type="text" class="form-control" value="'+$('#approx_budget').val()+'" disabled></td></tr>' +
            '<tr><td colspan="2"dataset><textarea type="text" class="form-control" disabled>'+$('#desc').val()+'</textarea></td></tr>' +
            '<div class="border rounded">' +
            '<table class="table table-borderless" id="item_content_'+display_item_table+'">' +
            '</table>' +
            '</div>');

        for (var i = 1; i < item_row_id + 1; i++){
            $('#item_content_'+display_item_table+'').append('<tr>' +
                '<td><input type="text" class="form-control" value="'+$('#item_id_'+i+'').val()+'" disabled></td>' +
                '<td><input type="text" class="form-control" value="'+$('#item_name_'+i+'').val()+'" disabled></td>' +
                '<td><input type="text" class="form-control" value="'+$('#uom_'+i+'').val()+'" disabled></td>' +
                '<td><input type="text" class="form-control" value="'+$('#unit_cost_'+i+'').val()+'" disabled></td>' +
                '<td><input type="text" class="form-control" value="'+$('#qty_'+i+'').val()+'" disabled></td>' +
                '<td><input type="text" class="form-control" value="'+$('#total_amount_'+i+'').val()+'" disabled></td>' +
                '</tr>');
        }
    }
});