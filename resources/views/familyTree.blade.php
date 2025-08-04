<x-layouts.app :title="__('Family Tree')">
    <script>
    document.addEventListener("DOMContentLoaded", function() {

        var family = new FamilyTree(document.getElementById("familyTreeCanvas"), {
            template: "main",
            mouseScrool: FamilyTree.none,
            menu: {
                pdf: { text: "Export PDF" },
                png: { text: "Export PNG" },
            },
            nodeBinding: {
                field_0: "relationship",
                field_1: "name",
                field_2: "bdate",
                field_3: "id",
                img_0: "img",
            },
            editForm: {
                buttons: null
            },
            orderBy: "orderId",
            tags: {
                "single_male": {
                    template: "single_male"
                },
                "single_female": {
                    template: "single_female"
                },
                "main_female_child": {
                    template: "main_female_child"
                },
                "main_male_child": {
                    template: "main_male_child"
                },
                "family_single_female": {
                    template: "family_single_female"
                },
                "family_single_male": {
                    template: "family_single_male"
                }
            }
        });

        family.on('render-link', function (sender, args) {
            if (args.cnode.ppid != undefined) {
                args.html += '<use xlink:href="#heart" x="' + args.p.xa + '" y="' + args.p.ya + '"/>';
            }
        });

        family.on('field', function (sender, args) {
            if (args.name == "bdate") {
                if (args.data["ddate"]) {
                    var bdate = args.data["bdate"];
                    var ddate = args.data["ddate"];
                    args.value = bdate + " - " + ddate;
                }
                else args.value = "";
            }

        });

        const persons = @json($persons);
        family.load(persons);
    });
    </script>
    <div id="familyTreeCanvas"></div>
</x-layouts.app>
