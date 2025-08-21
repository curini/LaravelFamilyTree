<x-layouts.app :title="__('Family Tree')">
    <div id="familyTreeCanvas" x-data x-init="window.initFamilyTree()" wire:ignore></div>
    <script>
        window.initFamilyTree = function() {
            const familyContent = document.getElementById("familyTreeCanvas");

            if (!familyContent) {
                return;
            }

            if (window.familyMap) {
                window.familyMap.remove();
            }

            window.familyMap = new FamilyTree(familyContent, {
                template: "main",
                scaleInitial: 0.60,
                mouseScrool: FamilyTree.none,
                menu: {
                    pdf: { text: "Export PDF" },
                    png: { text: "Export PNG" },
                },
                nodeBinding: {
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

            window.familyMap.on('render-link', function (sender, args) {
                if (args.cnode.ppid != undefined) {
                    args.html += '<use xlink:href="#heart" x="' + args.p.xa + '" y="' + args.p.ya + '"/>';
                }
            });

            window.familyMap.on('field', function (sender, args) {
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
            window.familyMap.load(persons);
        };
    </script>
</x-layouts.app>
