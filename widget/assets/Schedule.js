$.widget("execut.Schedule", {

    _create: function () {
        var t = this;
        t._initElements();
    },
    _initElements: function () {
        var t = this,
            el = t.element,
            opts = t.options;
        // if (!window.dhtmlXCombo)
        // 	alert("You need to have dhtmlxCombo files, to see full functionality of this sample.");

        scheduler.config.multi_day = true;

        scheduler.config.event_duration = 30;
        scheduler.config.auto_end_date = true;
        scheduler.config.details_on_create = true;
        scheduler.config.details_on_dblclick = true;

        scheduler.locale.labels.importSettingId = "Choose import setting:";
        var sections = [
            { name: "description", height: 50, map_to: "text", type: "textarea", focus: true },
            { name: "recurring", button: "recurring", map_to: "rec_type", type: "recurring"},
            { name: "time", height: 72, type: "time", map_to: "auto"}
        ];

        if (typeof opts.otherSections !== 'undefined') {
            for (var key = 0; key < opts.otherSections.length; key++) {
                var otherSection = opts.otherSections[key];
                sections[sections.length] = otherSection;
                if (typeof (opts.otherSections[key].default_value) !== 'undefined') {
                    scheduler.attachEvent("onEventCreated", function (id) {
                        scheduler.getEvent(id)[otherSection.name] = otherSection.default_value;
                    });
                }
            }
        }

        scheduler.config.lightbox.sections = sections;

        scheduler.config.xml_date = "%Y-%m-%d %H:%i";
        scheduler.init('scheduler_here', new Date(opts.positionDate), "week");
        scheduler.load(opts.url, function() {
            //show lightbox
            // scheduler.showLightbox("1261150549")
        });
        var dp = new dataProcessor(opts.url);
        dp.init(scheduler);
    },
});
