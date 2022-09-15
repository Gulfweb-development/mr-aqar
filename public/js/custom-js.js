function changeDriverType() {
    if($("#driver_type").val() === 'commission_based') {
        $("#commission").show();
    } else {
        $("#commission").hide();
    }
}
