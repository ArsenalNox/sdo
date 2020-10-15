$(document).ready(function () {


    $("#get_group").change(function() {
            clearlist();		
            var countryvalue = $("#get_group option:selected").val();
            if (countryvalue === '') {clearlist(); $('#get_name');  }
            getarea();
        })

    function getarea() {
        var country_value = $("#get_group option:selected").val();
        var p_id = $("#page_id").val();
        var area = $("#get_name");
        if (country_value === "") {
            area.attr("disabled",true);
        } else {
            area.attr("disabled",false);
            area.load('get_name.php',{group_student : country_value, page_id : p_id});
            $('#sub_region').css('display', 'block');
        }
    }

    function clearlist() {
        $("#get_name").empty();

    }	
});