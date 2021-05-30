$("#imgFileSelect").change(function(e) {
    const imgFileName = ($("#imgFileSelect")[0].value.split("\\")[2]);

    $("#imgFile").val(imgFileName);
});
