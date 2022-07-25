function ws_kenburns(c, j, k) {
    var d = jQuery;
    var e = document.createElement("canvas").getContext;
    var m = c.paths || [{
        from: [0, 0, 1],
        to: [0, 0, 1.2]
    }, {
        from: [0, 0, 1.2],
        to: [0, 0, 1]
    }, {
        from: [1, 0, 1],
        to: [1, 0, 1.2]
    }, {
        from: [0, 1, 1.2],
        to: [0, 1, 1]
    }, {
        from: [1, 1, 1],
        to: [1, 1, 1.2]
    }, {
        from: [0, 0, 1.2],
        to: [1, 0, 1.2]
    }, {
        from: [0, 1, 1.2],
        to: [1, 1, 1.2]
    }, {
        from: [1, 0, 1.2],
        to: [1, 1, 1.2]
    }, {
        from: [0, 0, 1.2],
        to: [0, 1, 1.2]
    }, {
        from: [1, 0, 1.2],
        to: [0, 1, 1.2]
    }, {
        from: [0.5, 1, 1],
        to: [0.5, 1, 1.3]
    }, {
        from: [1, 0.5, 1.2],
        to: [1, 0.5, 1]
    }, {
        from: [1, 0.5, 1],
        to: [1, 0.5, 1.2]
    }, {
        from: [0, 0.5, 1.2],
        to: [0, 0.5, 1]
    }, {
        from: [1, 0.5, 1.2],
        to: [1, 0.5, 1]
    }, {
        from: [0.5, 0.5, 1],
        to: [0.5, 0.5, 1.2]
    }, {
        from: [0.5, 0.5, 1.3],
        to: [0.5, 0.5, 1]
    }, {
        from: [0.5, 1, 1],
        to: [0.5, 0, 1.15]
    }];

    function a(h) {
        return m[h ? Math.floor(Math.random() * (e ? m.length : Math.min(10, m.length))) : 0]
    }

    function l(x, u) {
        var w, h = 0,
            t = 40 / u;
        var y = setInterval(function() {
            if (h < 1) {
                if (!w) {
                    w = 1;
                    x(h);
                    w = 0
                }
                h += t
            } else {
                v(1)
            }
        }, 40);

        function v(z) {
            clearInterval(y);
            if (z) {
                x(1)
            }
        }
        return {
            stop: v
        }
    }
    var i = c.width,
        o = c.height;
    var n;
    var f;
    if (e) {
        var b = d('<canvas width="' + i + '" height="' + o + '"/>');
        b.css({
            "z-index": 8,
            position: "absolute",
            left: 0,
            top: 0,
            width: "100%",
            height: "100%"
        }).appendTo(k);
        n = b.get(0).getContext("2d")
    } else {
        var b = d('<div style="width:100%;height:100%"></div>');
        b.css({
            "z-index": 8,
            position: "absolute",
            left: 0,
            top: 0
        }).appendTo(k);
        var g = [d('<img src="' + j.get(c.startSlide) + '"/>').css({
            position: "absolute",
            "z-index": 1
        }).appendTo(b)];
        g[1] = g[0].clone().appendTo(b).hide();
        var s = 0
    }

    function r(v, t, h) {
        var u = {
            width: 100 * v[2] + "%"
        };
        u[t ? "right" : "left"] = -100 * (v[2] - 1) * (t ? (1 - v[0]) : v[0]) + "%";
        u[h ? "bottom" : "top"] = -100 * (v[2] - 1) * (h ? (1 - v[1]) : v[1]) + "%";
        return u
    }
    var q;

    function p(h, v, t) {
        if (n) {
            if (f) {
                f.stop()
            }
            f = l(function(w) {
                var x = [v.from[0] * (1 - w) + w * v.to[0], v.from[1] * (1 - w) + w * v.to[1], v.from[2] * (1 - w) + w * v.to[2]];
                n.globalAlpha = (t ? Math.min(w * (1 + c.delay / c.duration), 1) : 1);
                n.drawImage(h, -i * (x[2] - 1) * x[0], -o * (x[2] - 1) * x[1], i * x[2], o * x[2])
            }, c.duration + c.delay);
            q = 0
        } else {
            if (t) {
                g[s].css({
                    "z-index": 1
                }).fadeOut(c.duration);
                s = s ? 0 : 1
            }
            var u = g[s].stop(1, 1).attr("src", h.src).css({
                "z-index": 2,
                left: "auto",
                right: "auto",
                top: "auto",
                bottom: "auto"
            }).css(r(v.from, v.from[0] > 0.5, v.from[1] > 0.5)).animate(r(v.to, v.from[0] > 0.5, v.from[1] > 0.5), {
                easing: "linear",
                queue: false,
                duration: (1.5 * c.duration + c.delay)
            });
            if (t) {
                u.fadeIn(c.duration, function() {
                    q = 0
                })
            } else {
                q = 0
            }
        }
    }
    j.each(function(h) {
        d(this).css({
            visibility: "hidden"
        });
        if (h == c.startSlide) {
            p(this, a(0), 0)
        }
    });
    this.go = function(h, t) {
        if (q) {
            return -1
        }
        q = 1;
        p(j.get(h), a(h), 1);
        return h
    }
}; // -----------------------------------------------------------------------------------

jQuery("#wowslider-container1").wowSlider({
    effect: "kenburns",
    //effect: "rotate",
    prev: "",
    next: "",
    duration: 20 * 100,
    delay: 20 * 100,
    width: 960,
    height: 360,
    autoPlay: true,
    stopOnHover: true,
    loop: false,
    bullets: true,
    caption: true,
    captionEffect: "slide",
    controls: true,
    logo: "engine1/loading.gif",
    onBeforeStep: 0,
    images: 0
});

// wowReInitor(jQuery("#wowslider-container1"),{fullScreen:true,effect:"slices",prev:"",next:"",duration:17*100,delay:22*100,width:960,height:360,autoPlay:true,stopOnHover:false,loop:false,bullets:true,caption:true,captionEffect:"move",controls:true,onBeforeStep:0,images:0});
