<x-layouts.app :title="__('Family Tree')">
    <div id="familyTreeCanvas" x-data x-init="window.initFamilyTree()" wire:ignore></div>
    <script>
        window.initFamilyTree = function() {
            const familyContent = document.getElementById("familyTreeCanvas");

            const mapIcon = `<svg width="24" height="24" viewBox="0 0 490 490" style="left: 12px;" >
                <polygon fill="#fff" points="320.217,101.428 171.009,5.241 171.009,392.966 320.217,485.979 	"/>
                <polygon fill="#fff" points="335.529,99.857 335.529,484.679 490,391.948 490,0 	"/>
                <polygon fill="#fff" points="155.697,3.659 0,82.979 0,490 155.697,392.942 	"/>
            </svg>`;

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
                    img_0: "img",
                },
                editForm: {
                    buttons: {
                        map: {
                            icon: mapIcon,
                            text: 'Map'
                        },
                        edit: null,
                        share: null,
                        pdf: null,
                        remove: null
                    },
                    generateElementsFromFields: false,
                    elements: [
                        { type: 'textbox', label: 'Gender', binding: 'gender' },
                        { type: 'textbox', label: 'Birthday', binding: 'bdate' },
                        { type: 'textbox', label: 'Deathday', binding: 'ddate' }
                    ]
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

            window.familyMap.editUI.on('button-click', function (sender, args) {
                if (args.name == 'map') {
                    var data = window.familyMap.get(args.nodeId);
                    window.open(data.map);
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
