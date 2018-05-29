function grizzly_notify(a, b) {
    if (jQuery(".option-update-status").remove(), "success" == b) var c = "success-status",
        d = "dashicons-yes";
    else if ("error" == b) var c = "error-status",
        d = "dashicons-no";
    jQuery("#grizzly-settings-wrap").prepend('<div style="display:none;" class="option-update-status ' + c + '"><span class="dashicons ' + d + '"></span>' + a + "</div>"), jQuery(".option-update-status").fadeIn("slow", function() {
        setTimeout(function() {
            jQuery(".option-update-status").fadeOut("slow")
        }, 4e3)
    }), jQuery(".option-update-status").click(function() {
        jQuery(this).remove()
    })
}
jQuery(document).ready(function(a) {
        function b(b, g) {
            var h = (a(".uploaded-file"), a(this));
            f = g, b.preventDefault(), e ? e.open() : (e = wp.media.frames.optionsframework_upload = wp.media({
                title: h.data("choose"),
                button: {
                    text: h.data("update"),
                    close: !1
                }
            }), e.on("select", function() {
                var b = e.state().get("selection").first();
                e.close(), f.find(".upload").val(b.attributes.url), "image" == b.attributes.type && (f.find(".screenshot").empty().hide().append('<img src="' + b.attributes.url + '"><a class="remove-image">Remove</a>').slideDown("fast"), $optionsopload = f.find(".upload"), d($optionsopload)), f.find(".upload-button").unbind().addClass("remove-file").removeClass("upload-button").val(optionsframework_l10n.remove), f.find(".of-background-properties").slideDown(), f.find(".remove-image, .remove-file").on("click", function() {
                    c(a(this).parents(".section"))
                })
            })), e.open()
        }

        function c(c) {
            c.find(".remove-image").hide(), c.find(".upload").val(""), c.find(".of-background-properties").hide(), c.find(".screenshot").slideUp(), c.find(".remove-file").unbind().addClass("upload-button").removeClass("remove-file").val(optionsframework_l10n.upload), a(".section-upload .upload-notice").length > 0 && (a(".upload-button").remove(), $optionsopload = f.find(".upload"), d($optionsopload)), c.find(".upload-button").on("click", function(c) {
                b(c, a(this).parents(".section"))
            })
        }

        function d(a) {
            var b = jQuery(a).closest("form").serialize(),
                c = window.location.href,
                d = c.split("wp-admin/")[0];
            d += "wp-admin/options.php", jQuery.ajax({
                url: d,
                type: "post",
                data: b,
                dataType: "html",
                success: function() {
                    jQuery(".option-update-status").remove(), jQuery("#grizzly-settings-wrap").prepend('<div class="updated notice option-update-status"><p>Option saved</p></div>'), setTimeout(function() {
                        jQuery(".option-update-status").remove()
                    }, 3e3)
                }
            })
        }
        var e, f;
        a(".remove-image, .remove-file").on("click", function() {
            c(a(this).parents(".section")), d(a(this))
        }), a(".upload-button").click(function(c) {
            b(c, a(this).parents(".section"))
        })
    }), jQuery(document).ready(function(a) {
        function b(a) {
            if ("import_data" == jQuery(a).attr("id")) return !1;
            var b = jQuery(a).closest("form").serialize(),
                c = window.location.href,
                d = c.split("wp-admin/")[0];
            d += "wp-admin/options.php", jQuery.ajax({
                url: d,
                type: "post",
                data: b,
                dataType: "html",
                success: function() {
                    grizzly_notify("Settings saved", "success")
                }
            })
        }
        a(".of-color").wpColorPicker({
            selected: function() {
                b(this)
            }
        });
        a(".save-button").click(function() {
            b(this)
        }), a(".of-radio-img-img").click(function() {
            a(this).parent().parent().find(".of-radio-img-img").removeClass("of-radio-img-selected"), a(this).addClass("of-radio-img-selected")
        }), a(".of-radio-img-label").hide(), a(".of-radio-img-img").show(), a(".of-radio-img-radio").hide(), a(".nav-tab-wrapper").length > 0 && function() {
            var b = a(".group"),
                c = a(".nav-tab-wrapper a"),
                d = "";
            b.hide(), "undefined" != typeof localStorage && (d = localStorage.getItem("active_tab")), "" != d && a(d).length ? (a(d).fadeIn(), a(d + "-tab").addClass("nav-tab-active")) : (a(".group:first").fadeIn(), a(".nav-tab-wrapper a:first").addClass("nav-tab-active")), c.click(function(d) {
                d.preventDefault(), c.removeClass("nav-tab-active"), a(this).addClass("nav-tab-active").blur(), "undefined" != typeof localStorage && localStorage.setItem("active_tab", a(this).attr("href"));
                var e = a(this).attr("href");
                b.hide(), a(e).fadeIn()
            })
        }();
        var c, d = wp.media.model.settings.post.id;
        jQuery("#upload_image_button").on("click", function(b) {
            if (b.preventDefault(), c) return c.uploader.uploader.param("post_id", 15), void c.open();
            wp.media.model.settings.post.id = 15, c = wp.media.frames.file_frame = wp.media({
                title: "Add image to Gallery",
                button: {
                    text: "Add to gallery"
                },
                multiple: !0
            }), c.on("select", function() {
                attachment = c.state().get("selection").first().toJSON();
                var b = c.state().get("selection").toJSON();
                a.each(b, function(b, c) {
                    var d = a(".image-preview-wrapper").find("li:first").clone(!0).show();
                    d.find("img").attr("src", c.sizes.thumbnail.url), d.find("input").val(c.id), a(".image-preview-wrapper").append(d)
                })
            }), c.open()
        }), jQuery("a.add_media").on("click", function() {
            wp.media.model.settings.post.id = d
        }), jQuery(".gallery-images").sortable({
            items: "li.image",
            cursor: "move",
            scrollSensitivity: 40,
            forcePlaceholderSize: !0,
            forceHelperSize: !1,
            helper: "clone",
            opacity: .65,
            placeholder: "gallery-metabox-sortable-placeholder",
            start: function(a, b) {
                b.item.css("background-color", "#f6f6f6")
            },
            stop: function(a, b) {
                b.item.removeAttr("style")
            },
            update: function(a, b) {}
        }), jQuery(".btn-gellery-remove").on("click", function() {
            jQuery(this).closest("li").remove()
        }), a('#grizzly-settings-wrap input[type="range"]').rangeslider({
            polyfill: !1,
            rangeClass: "rangeslider",
            fillClass: "rangeslider__fill",
            handleClass: "rangeslider__handle",
            onSlideEnd: function(a, b) {
                this.$element.closest(".controls").find(".range-value-display").text(b)
            },
            onInit: function(a, b) {
                this.$element.closest(".controls").find(".range-value-display").text(b)
            }
        }), jQuery("#grizzly-settings-wrap input,#grizzly-settings-wrap select,#grizzly-settings-wrap textarea,#grizzly-settings-wrap .wp-color-result,#grizzly-settings-wrap #background_pattern,#grizzly-settings-wrap #logo_url,#grizzly-settings-wrap #mobile_logo_url,#grizzly-settings-wrap #footer_logo_url").change(function() {
            b(this)
        }), jQuery(".section-images img").click(function() {
            b(this)
        })
    }), jQuery(function() {
        jQuery("#import_data").length > 0 && (jQuery("#export_data").prop("readonly", !0), jQuery("#import_data").after('<div class="import-options" ><a id="import-data-button" href="javascript:void(0)">Import</a><a id="clear-import-data-button" href="javascript:void(0)">Clear</a></div>'), jQuery("#import_data").val("")), jQuery("#clear-import-data-button").click(function() {
            jQuery("#import_data").val("")
        }), jQuery("#import-data-button").click(function() {
            if (confirm("you will lose all your current settings.do you want to continue?")) {
                var a = jQuery.trim(jQuery("#import_data").val()),
                    b = window.location.href,
                    c = b.split("wp-admin/")[0];
                c += "wp-admin/admin-ajax.php", jQuery.ajax({
                    url: c,
                    type: "post",
                    data: {
                        action: "import_grizzly_theme_settings",
                        import_data: a
                    },
                    dataType: "json",
                    success: function(a) {
                        jQuery("#import_data").val(""), grizzly_notify(a.message, a.status)
                    }
                })
            }
        })
    }),
    function(a) {
        "use strict";
        "function" == typeof define && define.amd ? define(["jquery"], a) : "object" == typeof exports ? module.exports = a(require("jquery")) : a(jQuery)
    }(function(a) {
        "use strict";

        function b(a, b) {
            var c = Array.prototype.slice.call(arguments, 2);
            return setTimeout(function() {
                return a.apply(null, c)
            }, b)
        }

        function c(a, b) {
            return b = b || 100,
                function() {
                    if (!a.debouncing) {
                        var c = Array.prototype.slice.apply(arguments);
                        a.lastReturnVal = a.apply(window, c), a.debouncing = !0
                    }
                    return clearTimeout(a.debounceTimeout), a.debounceTimeout = setTimeout(function() {
                        a.debouncing = !1
                    }, b), a.lastReturnVal
                }
        }

        function d(a) {
            return a && (0 === a.offsetWidth || 0 === a.offsetHeight || !1 === a.open)
        }

        function e(a) {
            for (var b = [], c = a.parentNode; d(c);) b.push(c), c = c.parentNode;
            return b
        }

        function f(a, b) {
            function c(a) {
                void 0 !== a.open && (a.open = !a.open)
            }
            var d = e(a),
                f = d.length,
                g = [],
                h = a[b];
            if (f) {
                for (var i = 0; i < f; i++) g[i] = d[i].style.cssText, d[i].style.setProperty ? d[i].style.setProperty("display", "block", "important") : d[i].style.cssText += ";display: block !important", d[i].style.height = "0", d[i].style.overflow = "hidden", d[i].style.visibility = "hidden", c(d[i]);
                h = a[b];
                for (var j = 0; j < f; j++) d[j].style.cssText = g[j], c(d[j])
            }
            return h
        }

        function g(a, b) {
            var c = parseFloat(a);
            return Number.isNaN(c) ? b : c
        }

        function h(a) {
            return a.charAt(0).toUpperCase() + a.substr(1)
        }

        function i(d, e) {
            if (this.$window = a(window), this.$document = a(document), this.$element = a(d), this.options = a.extend({}, m, e), this.polyfill = this.options.polyfill, this.orientation = this.$element[0].getAttribute("data-orientation") || this.options.orientation, this.onInit = this.options.onInit, this.onSlide = this.options.onSlide, this.onSlideEnd = this.options.onSlideEnd, this.DIMENSION = n.orientation[this.orientation].dimension, this.DIRECTION = n.orientation[this.orientation].direction, this.DIRECTION_STYLE = n.orientation[this.orientation].directionStyle, this.COORDINATE = n.orientation[this.orientation].coordinate, this.polyfill && l) return !1;
            this.identifier = "js-" + j + "-" + k++, this.startEvent = this.options.startEvent.join("." + this.identifier + " ") + "." + this.identifier, this.moveEvent = this.options.moveEvent.join("." + this.identifier + " ") + "." + this.identifier, this.endEvent = this.options.endEvent.join("." + this.identifier + " ") + "." + this.identifier, this.toFixed = (this.step + "").replace(".", "").length - 1, this.$fill = a('<div class="' + this.options.fillClass + '" />'), this.$handle = a('<div class="' + this.options.handleClass + '" />'), this.$range = a('<div class="' + this.options.rangeClass + " " + this.options[this.orientation + "Class"] + '" id="' + this.identifier + '" />').insertAfter(this.$element).prepend(this.$fill, this.$handle), this.$element.css({
                position: "absolute",
                width: "1px",
                height: "1px",
                overflow: "hidden",
                opacity: "0"
            }), this.handleDown = a.proxy(this.handleDown, this), this.handleMove = a.proxy(this.handleMove, this), this.handleEnd = a.proxy(this.handleEnd, this), this.init();
            var f = this;
            this.$window.on("resize." + this.identifier, c(function() {
                b(function() {
                    f.update(!1, !1)
                }, 300)
            }, 20)), this.$document.on(this.startEvent, "#" + this.identifier + ":not(." + this.options.disabledClass + ")", this.handleDown), this.$element.on("change." + this.identifier, function(a, b) {
                if (!b || b.origin !== f.identifier) {
                    var c = a.target.value,
                        d = f.getPositionFromValue(c);
                    f.setPosition(d)
                }
            })
        }
        Number.isNaN = Number.isNaN || function(a) {
            return "number" == typeof a && a !== a
        };
        var j = "rangeslider",
            k = 0,
            l = function() {
                var a = document.createElement("input");
                return a.setAttribute("type", "range"), "text" !== a.type
            }(),
            m = {
                polyfill: !0,
                orientation: "horizontal",
                rangeClass: "rangeslider",
                disabledClass: "rangeslider--disabled",
                activeClass: "rangeslider--active",
                horizontalClass: "rangeslider--horizontal",
                verticalClass: "rangeslider--vertical",
                fillClass: "rangeslider__fill",
                handleClass: "rangeslider__handle",
                startEvent: ["mousedown", "touchstart", "pointerdown"],
                moveEvent: ["mousemove", "touchmove", "pointermove"],
                endEvent: ["mouseup", "touchend", "pointerup"]
            },
            n = {
                orientation: {
                    horizontal: {
                        dimension: "width",
                        direction: "left",
                        directionStyle: "left",
                        coordinate: "x"
                    },
                    vertical: {
                        dimension: "height",
                        direction: "top",
                        directionStyle: "bottom",
                        coordinate: "y"
                    }
                }
            };
        return i.prototype.init = function() {
            this.update(!0, !1), this.onInit && "function" == typeof this.onInit && this.onInit()
        }, i.prototype.update = function(a, b) {
            a = a || !1, a && (this.min = g(this.$element[0].getAttribute("min"), 0), this.max = g(this.$element[0].getAttribute("max"), 100), this.value = g(this.$element[0].value, Math.round(this.min + (this.max - this.min) / 2)), this.step = g(this.$element[0].getAttribute("step"), 1)), this.handleDimension = f(this.$handle[0], "offset" + h(this.DIMENSION)), this.rangeDimension = f(this.$range[0], "offset" + h(this.DIMENSION)), this.maxHandlePos = this.rangeDimension - this.handleDimension, this.grabPos = this.handleDimension / 2, this.position = this.getPositionFromValue(this.value), this.$element[0].disabled ? this.$range.addClass(this.options.disabledClass) : this.$range.removeClass(this.options.disabledClass), this.setPosition(this.position, b)
        }, i.prototype.handleDown = function(a) {
            if (a.preventDefault(), this.$document.on(this.moveEvent, this.handleMove), this.$document.on(this.endEvent, this.handleEnd), this.$range.addClass(this.options.activeClass), !((" " + a.target.className + " ").replace(/[\n\t]/g, " ").indexOf(this.options.handleClass) > -1)) {
                var b = this.getRelativePosition(a),
                    c = this.$range[0].getBoundingClientRect()[this.DIRECTION],
                    d = this.getPositionFromNode(this.$handle[0]) - c,
                    e = "vertical" === this.orientation ? this.maxHandlePos - (b - this.grabPos) : b - this.grabPos;
                this.setPosition(e), b >= d && b < d + this.handleDimension && (this.grabPos = b - d)
            }
        }, i.prototype.handleMove = function(a) {
            a.preventDefault();
            var b = this.getRelativePosition(a),
                c = "vertical" === this.orientation ? this.maxHandlePos - (b - this.grabPos) : b - this.grabPos;
            this.setPosition(c)
        }, i.prototype.handleEnd = function(a) {
            a.preventDefault(), this.$document.off(this.moveEvent, this.handleMove), this.$document.off(this.endEvent, this.handleEnd), this.$range.removeClass(this.options.activeClass), this.$element.trigger("change", {
                origin: this.identifier
            }), this.onSlideEnd && "function" == typeof this.onSlideEnd && this.onSlideEnd(this.position, this.value)
        }, i.prototype.cap = function(a, b, c) {
            return a < b ? b : a > c ? c : a
        }, i.prototype.setPosition = function(a, b) {
            var c, d;
            void 0 === b && (b = !0), c = this.getValueFromPosition(this.cap(a, 0, this.maxHandlePos)), d = this.getPositionFromValue(c), this.$fill[0].style[this.DIMENSION] = d + this.grabPos + "px", this.$handle[0].style[this.DIRECTION_STYLE] = d + "px", this.setValue(c), this.position = d, this.value = c, b && this.onSlide && "function" == typeof this.onSlide && this.onSlide(d, c)
        }, i.prototype.getPositionFromNode = function(a) {
            for (var b = 0; null !== a;) b += a.offsetLeft, a = a.offsetParent;
            return b
        }, i.prototype.getRelativePosition = function(a) {
            var b = h(this.COORDINATE),
                c = this.$range[0].getBoundingClientRect()[this.DIRECTION],
                d = 0;
            return void 0 !== a.originalEvent["client" + b] ? d = a.originalEvent["client" + b] : a.originalEvent.touches && a.originalEvent.touches[0] && void 0 !== a.originalEvent.touches[0]["client" + b] ? d = a.originalEvent.touches[0]["client" + b] : a.currentPoint && void 0 !== a.currentPoint[this.COORDINATE] && (d = a.currentPoint[this.COORDINATE]), d - c
        }, i.prototype.getPositionFromValue = function(a) {
            var b;
            return b = (a - this.min) / (this.max - this.min), Number.isNaN(b) ? 0 : b * this.maxHandlePos
        }, i.prototype.getValueFromPosition = function(a) {
            var b, c;
            return b = a / (this.maxHandlePos || 1), c = this.step * Math.round(b * (this.max - this.min) / this.step) + this.min, Number(c.toFixed(this.toFixed))
        }, i.prototype.setValue = function(a) {
            a === this.value && "" !== this.$element[0].value || this.$element.val(a).trigger("input", {
                origin: this.identifier
            })
        }, i.prototype.destroy = function() {
            this.$document.off("." + this.identifier), this.$window.off("." + this.identifier), this.$element.off("." + this.identifier).removeAttr("style").removeData("plugin_" + j), this.$range && this.$range.length && this.$range[0].parentNode.removeChild(this.$range[0])
        }, a.fn[j] = function(b) {
            var c = Array.prototype.slice.call(arguments, 1);
            return this.each(function() {
                var d = a(this),
                    e = d.data("plugin_" + j);
                e || d.data("plugin_" + j, e = new i(this, b)), "string" == typeof b && e[b].apply(e, c)
            })
        }, "rangeslider.js is available in jQuery context e.g $(selector).rangeslider(options);"
    });