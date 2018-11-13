var path;
var ball;
var firstBall;
var textItem;
var drawALine = true;
var ballSize = 20;
var textSize = 20;
var centerPoint = [-7, -8] ;
var fontWeight = "Normal";

function onMouseUp(event) {
    console.log("click");
    if (drawALine) {
        if (!path) {
            path = new Path({
                segments: [event.point],
                strokeColor: 'black',
                // Select the path, so we can see its segment points:
                fullySelected: true,
                dashArray: [10, 4],
                strokeColor: new Color(1, 1, 1),
                        strokeWidth: 3
            });
        } else {
            path.add(event.point);
            path.smooth();
        }
    } else {
        if (ball) {
            ball.remove();
            textItem.remove();
        }

        ball = new Path.Circle(event.point, ballSize);
        ball.fillColor = 'white';
        textItem = new PointText({
            content: $("#backbundle_via_order").val(),
            point: new Point(event.point.x + centerPoint[0], event.point.y + centerPoint[1]),
            fillColor: 'black',
            fontSize: textSize,
			fontWeight: fontWeight
        });
    }

    node = paper.project.exportSVG();
    node.setAttribute("viewBox", "0 0 730 548");
    node.removeAttribute("width");
    node.removeAttribute("height");
    node.classList.add("line-" + $("#backbundle_via_order").val());
    //$("#svgcontainer").find("svg").remove();
    //document.getElementById("svgcontainer").appendChild(node); 
    //var tmp = document.createElement("div");
    //tmp.appendChild(node);

    $("#backbundle_via_draw").val(node.innerHTML);
    $("#preview").val(node.innerHTML);

}

function onKeyUp(event) {
    console.log(event.key);
    if (event.key == "enter") {
        path.fullySelected = true;
    }

    if (event.key == "backspace" && path && path.segments.length > 0) {
        path.removeSegment(path.segments.length - 1);
    }

}

$("#line").click(function (event) {
    event.preventDefault();
    $(".via-vector-editor a").removeClass("active");
    $(this).addClass("active");
    drawALine = true;
});
$("#ball").click(function (event) {
    event.preventDefault();
    $(".via-vector-editor a").removeClass("active");
    $(this).addClass("active");
    drawALine = false;
});

$(".ball.size10").click(function (event) {
    event.preventDefault();
	$(".via-vector-editor a").removeClass("active");
    $(this).addClass("active");
    drawALine = false;
	
    $(".ball-size").removeClass("active");
    $(this).addClass("active");
    ballSize = 10;
	textSize = 11;
	centerPoint = [-3, 4];
	fontWeight = 'Bold';
});

$(".ball.size20").click(function (event) {
     event.preventDefault();
	$(".via-vector-editor a").removeClass("active");
    $(this).addClass("active");
    drawALine = false;
	
    $(".ball-size").removeClass("active");
    $(this).addClass("active");
    ballSize = 20;
	textSize = 25;
	centerPoint = [-7, 8] ;
	fontWeight = 'Normal';
});


