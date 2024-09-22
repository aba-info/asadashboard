$(function () {
    if ($("#project-autocomplete").length > 0) {
        $("#project-autocomplete")
            .autocomplete({
                source: function (request, response) {
                    var projects = $("#project-ids").val().split(","); // Fetch project names from hidden input
                    response($.ui.autocomplete.filter(projects, request.term));
                },
                minLength: 1,
                select: function (event, ui) {
                    $("#project-id").val(ui.item.value);
                    /* 
                    LOADING PHASES 
                */
                    var selectElement = $("#phase_id");
                    selectElement.empty();
                    selectElement.append(
                        $("<option>", {
                            value: "0",
                            text: "loading phases...",
                        })
                    );

                    fetchPhases();
                    createPhaseLink();
                },
            })
            .autocomplete("instance")._renderItem = function (ul, item) {
            return $("<li>")
                .append("<div>" + item.value + "</div>")
                .appendTo(ul);
        };

        $("#project-autocomplete").on("change", function () {
            if($(this).val()==""){
                $("#phase_id").html($("#phases_temp").html());
            }
        });
    }

    if ($(".action-show-project").length > 0) {
        $(".action-show-project").each(function (index, element) {
            $(element).on("click", function () {
                $("tr.projects__phase").hide(400);
                let affRow = $("tr.projects__phase[data-project='" + $(element).data("project") + "']");
                affRow.toggle(400);
            });
        });
    }

    if ($("#timesheets-filter").length > 0) {
        $('#timesheets-filter').on('submit', function(e) {
            e.preventDefault();
            $('#project-ids').val('url');
            this.submit();
        });
    }
});

function fetchPhases() {
    var projectName = $("#project-id").val(); // Get the selected project name
    $.ajax({
        url: "/fetch-phases",
        type: "GET",
        data: { projectName: projectName },
        success: function (response) {
            var selectElement = $("#phase_id");
            selectElement.empty();
            if ($("#timesheets-filter").length > 0) {
                selectElement.append(
                    $("<option>", {
                        value: "",
                        text: "All phases",
                    })
                );
            }
            $.each(response, function (index, phase) {
                selectElement.append(
                    $("<option>", {
                        value: phase,
                        text: phase,
                    })
                );
            });
        },
        error: function () {
            console.log("Error fetching phases.");
        },
    });
}

function createPhaseLink() {
    let link = $(".create__phase");
    let baseUrl = link.attr("href").split('?')[0];

    link.attr("href", baseUrl + "?project=" + $("#project-id").val());
}
