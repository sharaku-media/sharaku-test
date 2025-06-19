let map;
let markers = [];
let currentSelectedMarker = null;
const defaultIcon = "http://maps.google.com/mapfiles/ms/icons/red-dot.png";
const selectedIcon = "http://maps.google.com/mapfiles/ms/icons/blue-dot.png";

function initMap() {
    // デフォルトの中心位置（大阪）
    const defaultCenter = { lat: 34.6937, lng: 135.5023 };

    // 地図の初期化
    map = new google.maps.Map(document.getElementById("map"), {
        center:
            locations.length > 0
                ? { lat: parseFloat(locations[0].lat), lng: parseFloat(locations[0].lng) }
                : defaultCenter,
        zoom: 13,
        styles: [
            {
                featureType: "poi",
                elementType: "labels",
                stylers: [{ visibility: "off" }],
            },
        ],
    });

    const infoWindow = new google.maps.InfoWindow();

    // マーカーの作成
    locations.forEach((location) => {
        const marker = new google.maps.Marker({
            position: {
                lat: parseFloat(location.lat),
                lng: parseFloat(location.lng),
            },
            map: map,
            icon: defaultIcon,
            title: location.title,
        });

        // マーカーのクリックイベント
        marker.addListener("click", () => {
            infoWindow.setContent(`
                <div style="padding: 10px;">
                    <h3 style="margin-bottom: 8px;">${location.title}</h3>
                    <img src="${location.image}" style="width: 150px; height: 100px; object-fit: cover; margin-bottom: 8px;">
                    <p>${location.description}</p>
                </div>
            `);
            infoWindow.open(map, marker);

            // マーカーのハイライト
            if (currentSelectedMarker) {
                currentSelectedMarker.setIcon(defaultIcon);
            }
            marker.setIcon(selectedIcon);
            currentSelectedMarker = marker;
        });

        markers.push(marker);
    });
}

// 地図の初期化を実行
window.initMap = initMap;
