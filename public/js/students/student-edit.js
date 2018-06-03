// student info obj
var std = {};
function edit(evt)
{
    evt.preventDefault();
    // enable form
    $("input, select").removeAttr("readonly");
    $("input[type='file']").removeAttr("disabled");
    $("button").removeClass("hide");
    std.code = $("#code").val();
    std.english_name = $("#english_name").val();
    std.khmer_name = $("#khmer_name").val();
    std.gender = $("#gender").val();
    std.dob = $("#dob").val();
    std.pob = $("#pob").val();
    std.phone = $("#phone").val();
    std.email = $("#email").val();
    std.address = $("#current_address").val();
    std.photo = $("#preview").attr("src");
    std.branch = $("#branch").val();
}
// cancel edit
function cancelEdit()
{
    $("#code").val(std.code);
    $("#english_name").val(std.english_name);
    $("#khmer_name").val(std.khmer_name);
    $("#gender").val(std.gender);
    $("#dob").val(std.dob);
    $("#pob").val(std.pob);
    $("#phone").val(std.phone);
    $("#email").val(std.email);
    $("#current_address").val(std.address);
    $("#preview").attr('src', std.photo);
    $("button").addClass("hide");
    $("input, select").attr("readonly", "true");
    $("input[type='file']").val("");
    $("#branch").val(std.branch);
}
// save edit
function save()
{
    var o = confirm('Do you want to save changes?');
        if(o)
        {
            var file_data = $('#photo').prop('files')[0];
            var form_data = new FormData();
            form_data.append('photo', file_data);
            form_data.append('student_id', $("#student_id").val());
            form_data.append("code", $("#code").val());
            form_data.append("english_name", $("#english_name").val());
            form_data.append("khmer_name", $("#khmer_name").val());
            form_data.append("gender", $("#gender").val());
            form_data.append("dob", $("#dob").val());
            form_data.append("pob", $("#pob").val());
            form_data.append("phone", $("#phone").val());
            form_data.append("email", $("#email").val());
            form_data.append("address", $("#current_address").val());
            form_data.append("branch_id", $("#branch").val());

            $("#sms").html("<img src='" + asset + "/ajax-loader.gif" + "'>");
            $.ajax({
                type: 'POST',
                url:burl + '/student/update',
                data: form_data,
                type: 'POST',
                contentType: false,       // The content type used when sending data to the server.
                cache: false,             // To unable request pages to be cached
                processData: false,
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("input[name='_token']").val());
                },
                success:function(sms){

                     location.href= burl + "/student/detail/" + $("#student_id").val();

                },
            });

        }
}
// save document
function saveDoc () {
      var o = confirm('Do you want to save?');
        if(o)
        {
            var file_data = $('#doc_file_name').prop('files')[0];
            var form_data = new FormData();
            form_data.append('doc_file_name', file_data);
            form_data.append('student_id', $("#student_id").val());
            form_data.append("description", $('#doc_description').val());
            $("#docsms").html("<img src='" + asset + "/ajax-loader.gif" + "'>");
            $.ajax({
                type: 'POST',
                url:burl + '/document/save',
                data: form_data,
                type: 'POST',
                contentType: false,       // The content type used when sending data to the server.
                cache: false,             // To unable request pages to be cached
                processData: false,
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("input[name='_token']").val());
                },
                success:function(sms){
                   sms = JSON.parse(sms);
                    var tr = "";
                    tr +="<tr id='" + sms.id + "'>";
                    tr +="<td>" + sms.description+ "</td>";
                    tr += "<td>" + "<a href='" + doc_url + "/" + sms.file_name + "' target='_blank'>" + sms.file_name + "</a>" + "</td>";
                    tr += "<td>" + "<a href='#' onclick='deleteDoc(this,event)'><i class='fa fa-remove text-danger'></i></a>" + "</td>";
                    tr +="</tr>";
                    var counter = $("#docData tr").length;
                    if(counter>0){
                        $("#docData tr:last-child").after(tr);
                    }
                    else{
                        $("#docData").html(tr);
                    }
                    $("#docsms").html("Your doc has been saved!<br>ឯកសារត្រូវបានរក្សាទុកដោយជោគជ័យ!");
                    $("#doc_description").val("");
                    $("#doc_file_name").val("");
                },
            });

        }
}
// delete a document by its id
function deleteDoc (obj, evt) {
    var tr = $(obj).parent().parent();
    var id = $(tr).attr('id');
    var con = confirm('You want to delete?');
    if(con)
    {
        $.ajax({
        type: "GET",
        url: burl + "/document/delete/" + id,
        success: function (response) {
            $(tr).remove();
        }
    });
    }
   
}
// function clear modal when click cancel for family modal
function clearCancel() {
    $("#full_name").val("");
    $("#fdob").val("");
    $("#fphone").val("");
    $("#faddress").val("");
    $("#fcareer").val("");
    $("#fstatus").val("");
    $("#fsms").html("");
    $("#family_id").val("0");
}
function clearDoc() {
    $("#doc_description").val("");
    $("#doc_file_name").val("");
    $("#docsms").html("");
    $("#doc_id").val("0");
}
// clear health
function clearHealth()
{
    $("#hcheck_date").val("");
    $("#hweight").val("");
    $("#hheight").val("");
    $("#hleft_eye").val("");
    $("#hright_eye").val("");
    $("#hleft_ear").val("");
    $("#hright_ear").val("");
    $("#htop_tooth").val("");
    $("#hbottom_tooth").val("");
    $("#hother").val("");
    $("#hconclusion").val("");
    $("#hsms").html("");
}
// clear registration
function clearRegistration()
{
    $("#register_date").val("");
    $("#start_date").val("");
    $("#end_date").val("");
    $("#registration_id").val("0");
    $("#regsms").html("");
}
// save health
function saveHealth()
{
    var health = {
        id: $("#health_id").val(),
        check_date: $("#hcheck_date").val(),
        check_time: $("#hcheck_time").val(),
        weight: $("#hweight").val(),
        height: $("#hheight").val(),
        left_eye: $("#hleft_eye").val(),
        right_eye: $("#hright_eye").val(),
        left_ear: $("#hleft_ear").val(),
        right_ear: $("#hright_ear").val(),
        top_tooth: $("#htop_tooth").val(),
        bottom_tooth: $("#hbottom_tooth").val(),
        other: $("#hother").val(),
        conclusion: $("#hconclusion").val(),
        student_id: $("#student_id").val()
    };
    $.ajax({
            type: "POST",
            url: burl + "/health/save",
            data: health,
            beforeSend: function (request) {
                return request.setRequestHeader('X-CSRF-Token', $("input[name='_token']").val());
            },
            success: function (sms) {
                var h_id = $("#health_id").val();
                if(h_id<=0)
                {
                    // you insert data
                    if(sms>0)
                    {
                        var tr = "<tr id='" + sms + "'>";
                        tr += "<td>" + health.check_time + "</td>";
                        tr += "<td>" + health.check_date + "</td>";
                        tr += "<td>" + health.weight + "</td>";
                        tr += "<td>" + health.height + "</td>";
                        tr += "<td>" + health.lef_eye + "</td>";
                        tr += "<td>" + health.right_eye + "</td>";
                        tr += "<td>" + health.left_ear + "</td>";
                        tr += "<td>" + health.right_ear + "</td>";
                        tr += "<td>" + health.top_tooth + "</td>";
                        tr += "<td>" + health.bottom_tooth + "</td>";
                        tr += "<td>" + health.conclusion + "</td>";
                        tr += "<td>" + health.other + "</td>";
                        tr += "<td>" + "<a href='#' onclick='editHealth(this, event)'><i class='fa fa-edit text-success'></i></a>&nbsp;&nbsp;<a href='#' onclick='removeHealth(this, event)'><i class='fa fa-remove text-danger'></i></a>" + "</td>";
                        tr += "<tr>";
                        $("#hcheck_date").val("");
                        $("#hweight").val("");
                        $("#hheight").val("");
                        $("#hleft_eye").val("");
                        $("#hright_eye").val("");
                        $("#hleft_ear").val("");
                        $("#hright_ear").val("");
                        $("#htop_tooth").val("");
                        $("#hbottom_tooth").val("");
                        $("#hother").val("");
                        $("#hconclusion").val("");
                        var counter = $("#healthData tr").length;
                        if(counter>0)
                        {
                            $("#healthData tr:last-child").after(tr);
                        }
                        else{
                            $("#healthData").html(tr);
                        }
                        $("#hsms").html("Data has been saved successfully.<br>ទិន្នន័យត្រូវបានរក្សាទុកដោយជោគជ័យ។");
                    }
                    else{
                        $("#hsms").html("Fail to save data. Please check again!<br>មិនអាចរក្សាទិន្នន័យបានទេ។ សូមពិន្យម្តងទៀត!");
                    }
                }
                else{
                    // you update data
                    // get updated row
                    var str = $("tr[id='" + health.id + "']")
                    var tds = $(str).children("td");
                    $(tds[0]).html(health.check_time);
                    $(tds[1]).html(health.check_date);
                    $(tds[2]).html(health.weight);
                    $(tds[3]).html(health.height);
                    $(tds[4]).html(health.left_eye);
                    $(tds[5]).html(health.right_eye);
                    $(tds[6]).html(health.left_ear);
                    $(tds[7]).html(health.right_ear);
                    $(tds[8]).html(health.top_tooth);
                    $(tds[9]).html(health.bottom_tooth);
                    $(tds[10]).html(health.conclusion);
                    $(tds[11]).html(health.other);
                    $("#hsms").html("All changes have been saved successfully!<br>ទិន្នន័យត្រូវបានផ្លាស់ប្តូរដោយជោគជ័យ!");
                }
            }
    });

}
// save registration
function saveRegistration()
{
    var registration = {
        id: $("#registration_id").val(),
        registration_date: $("#register_date").val(),
        class_id: $("#class").val(),
        year_id: $("#year").val(),
        start_date: $("#start_date").val(),
        end_date: $("#end_date").val(),
        student_id: $("#student_id").val(),
        class: $("#class option:selected").text(),
        year: $("#year option:selected").text()
    };
    $.ajax({
            type: "POST",
            url: burl + "/registration/save",
            data: registration,
            beforeSend: function (request) {
                return request.setRequestHeader('X-CSRF-Token', $("input[name='_token']").val());
            },
            success: function (sms) {
                var re_id = $("#registration_id").val();
                if(re_id<=0)
                {
                    if (sms > 0) {
                        // bind to table
                        var tr = "<tr id='" + sms + "' year-id='" + registration.year_id + "' class-id='" + registration.class_id + "'>";
                        tr += "<td>" + registration.registration_date + "</td>";
                        tr += "<td>" + registration.class + "</td>";
                        tr += "<td>" + registration.year + "</td>";
                        tr += "<td>" + registration.start_date + "</td>";
                        tr += "<td>" + registration.end_date + "</td>";
                        tr += "<td>" + "<a href='#' onclick='removeRegistration(this, event)'><i class='fa fa-remove text-danger'></i></a>" + "</td>";
                        tr += "<tr>";
                        // <a href='#' onclick='editRegistration(this, event)'><i class='fa fa-edit text-success'></i></a>&nbsp;&nbsp;
                        if ($("#rdata tr").length > 0) {
                            $("#rdata tr:last-child").after(tr);
                        }
                        else {
                            $("#rdata").html(tr);
                        }
                        $("#register_date").val("");
                        $("#start_date").val("");
                        $("#end_date").val("");
                        $("#registration_id").val("0");
                        $("#regsms").html("Data has been saved! (ទិន្នន័យត្រូវបានរក្សាទុកដោយជោគជ័យ!)")
                    }
                    else{
                        $("#regsms").html("Cannot save your data. Please check again! មិនអាចរក្សាទិន្នន័យ");
                    }
                }
                else{
                    // update part
                    if(sms)
                    {
                        // update data in grid
                      
                        $("#fsms").html("Data has been saved! ទិន្នន័យត្រូវបានផ្លាស់ប្តូរដោយជោគជ័យ!")
                    }
                    else{
                        $("#fsms").html("Cannot save changes. Please check again! មិនអាចផ្លាស់ប្តូរទិន្នន័យបានទេ!");
                    }
                }

            }
        });
}
// function to save family
function saveFamily() {
    var family = {
        relation_type: $("#frelation").val(),
        full_name: $("#full_name").val(),
        gender: $("#fgender").val(),
        phone: $("#fphone").val(),
        address: $("#faddress").val(),
        student_id: $("#sid").val(),
        family_id: $("#family_id").val(),
        dob: $("#fdob").val(),
        career: $("#fcareer").val(),
        status: $("#fstatus").val(),
        isAlive: $("#falive").val(),
        isDisabled: $("#fdisable").val(),
        isMinority: $("#fminority").val()
    };
    // full name is required
    if(family.full_name.length<3)
    {
        alert("Full name is required!");
    }
    else{
        // send to db
        $.ajax({
            type: "POST",
            url: burl + "/family/save",
            data: family,
            beforeSend: function (request) {
                return request.setRequestHeader('X-CSRF-Token', $("input[name='_token']").val());
            },
            success: function (sms) {
                var fid = $("#family_id").val();
                if(fid<=0)
                {
                    if (sms > 0) {
                        // bind to table
                        var tr = "<tr id='" + sms + "'>";
                        tr += "<td>" + family.full_name + "</td>";
                        tr += "<td>" + family.gender + "</td>";
                        tr += "<td>" + family.dob + "</td>";
                        tr += "<td>" + family.address + "</td>";
                        tr += "<td>" + family.career + "</td>";
                        tr += "<td>" + family.status + "</td>";
                        tr += "<td>" + family.phone + "</td>";
                        tr += "<td>" + family.relation_type + "</td>";
                        tr += "<td>" + family.isAlive + "</td>";
                        tr += "<td>" + family.isDisabled + "</td>";
                        tr += "<td>" + family.isMinority + "</td>";
                        tr += "<td>" + "<a href='#' onclick='editFamily(this, event)'><i class='fa fa-edit text-success'></i></a>&nbsp;&nbsp;<a href='#' onclick='removeFamily(this, event)'><i class='fa fa-remove text-danger'></i></a>" + "</td>";
                        tr += "<tr>";
                        if ($("#data tr").length > 0) {
                            $("#data tr:last-child").after(tr);
                        }
                        else {
                            $("#data").html(tr);
                        }
                        $("#full_name").val("");
                        $("#fdob").val("");
                        $("#fphone").val("");
                        $("#faddress").val("");
                        $("#fstatus").val("");
                        $("#fcareer").val("");
                        $("#fsms").html("Data has been saved! (ទិន្នន័យត្រូវបានរក្សាទុកដោយជោគជ័យ!)")
                    }
                    else{
                        $("#fsms").html("Cannot save your data. Please check again! មិនអាចរក្សាទិន្នន័យ");
                    }
                }
                else{
                    // update part
                    if(sms)
                    {
                        // update data in grid
                        var str = "tr[id='" + family.family_id + "']";
                        var tds = $(str).children("td");
                        $(tds[0]).html(family.full_name);
                        $(tds[1]).html(family.gender);
                        $(tds[2]).html(family.dob);
                        $(tds[3]).html(family.address);
                        $(tds[4]).html(family.career);
                        $(tds[5]).html(family.status);
                        $(tds[6]).html(family.phone);
                        $(tds[7]).html(family.relation_type);
                        $(tds[8]).html(family.isAlive);
                        $(tds[9]).html(family.isDisabled);
                        $(tds[10]).html(family.isMinority);
                        $("#fsms").html("Data has been saved! ទិន្នន័យត្រូវបានផ្លាស់ប្តូរដោយជោគជ័យ!")
                    }
                    else{
                        $("#fsms").html("Cannot save changes. Please check again! មិនអាចផ្លាស់ប្តូរទិន្នន័យបានទេ!");
                    }
                }

            }
        });
    }
}
// remove family
function removeFamily(obj, evt) {
    evt.preventDefault();
    var tr = $(obj).parent().parent();
    var family_id = $(tr).attr("id");
    var o = confirm("You want to delete?");
    if(o)
    {
        $.ajax({
            type: "GET",
            url: burl + "/family/delete/" + family_id,
            success: function (sms) {
                if(sms)
                {
                    tr.remove();
                }
            }
        });
    }

}
// function to remove health
function removeHealth(obj, evt)
{
    evt.preventDefault();
    var tr = $(obj).parent().parent();
    var health_id = $(tr).attr("id");
    var o = confirm("You want to delete?");
    if(o)
    {
        $.ajax({
            type: "GET",
            url: burl + "/health/delete/" + health_id,
            success: function (sms) {
                if(sms)
                {
                    tr.remove();
                }
            }
        });
    }
}
// delete registration
function removeRegistration(obj, evt)
{
    evt.preventDefault();
    var tr = $(obj).parent().parent();
    var register_id = $(tr).attr("id");
    var o = confirm("You want to delete?");
    if(o)
    {
        $.ajax({
            type: "GET",
            url: burl + "/registration/delete/" + register_id,
            success: function (sms) {
                if(sms)
                {
                    tr.remove();
                }
            }
        });
    }
}
// edit family
function editFamily(obj, evt) {
  evt.preventDefault();
    var tr = $(obj).parent().parent();
    var tds = $(tr).children("td");
    var family = {
        id: $(tr).attr("id"),
        full_name: $(tds[0]).html(),
        gender: $(tds[1]).html(),
        dob: $(tds[2]).html(),
        address: $(tds[3]).html(),
        career: $(tds[4]).html(),
        status: $(tds[5]).html(),
        phone: $(tds[6]).html(),
        relation_type: $(tds[7]).html(),
        isAlive: $(tds[8]).html(),
        isDisabled: $(tds[9]).html(),
        isMinority: $(tds[10]).html()
    };
    $("#family_id").val(family.id);
    $("#full_name").val(family.full_name);
    $("#fdob").val(family.dob);
    $("#fgender").val(family.gender);
    $("#faddress").val(family.address);
    $("#fphone").val(family.phone);
    $("#frelation").val(family.relation_type);
    $("#fcareer").val(family.career);
    $("#fstatus").val(family.status);
    $("#falive").val(family.isAlive);
    $("#fdisable").val(family.isDisabled);
    $("#fminority").val(family.isMinority);
    $("#btnAddFamily").trigger("click");
}
// edit health
function editHealth(obj, evt)
{
    evt.preventDefault();
    var tr = $(obj).parent().parent();
    var tds = $(tr).children("td");
    var health = {
        id: $(tr).attr("id"),
        check_time: $(tds[0]).html(),
        check_date: $(tds[1]).html(),
        weight: $(tds[2]).html(),
        height: $(tds[3]).html(),
        left_eye: $(tds[4]).html(),
        right_eye: $(tds[5]).html(),
        left_ear: $(tds[6]).html(),
        right_ear: $(tds[7]).html(),
        top_tooth: $(tds[8]).html(),
        bottom_tooth: $(tds[9]).html(),
        conclusion: $(tds[10]).html(),
        other: $(tds[11]).html()
    };
    $("#health_id").val(health.id);
    $("#hweight").val(health.weight);
    $("#hheight").val(health.height);
    $("#hcheck_time").val(health.check_time);
    $("#hcheck_date").val(health.check_date);
    $("#hleft_eye").val(health.left_eye);
    $("#hright_eye").val(health.right_eye);
    $("#hleft_ear").val(health.left_ear);
    $("#hright_ear").val(health.right_ear);
    $("#htop_tooth").val(health.top_tooth);
    $("#hbottom_tooth").val(health.bottom_tooth);
    $("#hother").val(health.other);
    $("#hconclusion").val(health.conclusion);
    $("#btnAddHealth").trigger("click");
}