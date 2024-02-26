// import Snap from 'snapsvg';
import 'snapsvg-cjs';

function arc(centerX, centerY, radius, angle) {
    return {
        startX: centerX - Math.cos(angle) * radius,
        endX: centerX + Math.cos(angle) * radius,
        y: centerY - Math.sin(angle) * radius,
    }
}

const createCountdown = (containerId) => {
    const RADIUS = 100;
    const paper = Snap(`#${containerId}`);
    paper.clear();
    console.log("snapped :", paper);
    const centerX = 150;
    const centerY = 150;
    const circle = paper.circle(centerX, centerY, RADIUS);
    circle.attr({
        fill: "#bada55",
        stroke: "#000",
        strokeWidth: 5
    });

    // const angle = (3 / 4) * Math.PI - 0.01;
    const angle = Math.PI / 2 - 0.01;
    // const angle = -Math.PI / 4;
    // const angle = Math.PI/8;
    // const angle = 0;

    let {startX, endX, y} = arc(centerX, centerY, RADIUS, angle);

    const path = paper.path(`M ${startX} ${y} A ${RADIUS} ${RADIUS} 0 0 0 ${endX} ${y}`);

    // ({startX,endX, y} = arc(centerX, centerY, RADIUS, 2*angle));
    // path.animate({d: `M ${startX} ${y} A ${RADIUS} ${RADIUS} 0 1 0 ${endX} ${y}`}, 1000)
    // circle.animate({r: 50}, 1000);
}

export {createCountdown};
