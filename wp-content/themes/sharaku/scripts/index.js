const locationList = document.querySelector(".location-list-container");
const dumpLocations = [
    {
        name: "大阪城",
        address: "大阪府大阪市中央区",
        tags: ["城", "夏"],
        imageUrl: "https://i.pinimg.com/736x/bb/ba/4e/bbba4e9d5ead7cfda8818b7bee2b5ad7.jpg",
    },
    {
        name: "東京タワー",
        address: "東京都港区芝公園4丁目2-8",
        tags: ["塔", "夜景"],
        imageUrl: "https://i.pinimg.com/736x/36/c5/3d/36c53d953e818f7f2536bf75f6240ee3.jpg",
    },
    {
        name: "富士山",
        address: "山梨県富士吉田市",
        tags: ["山", "冬"],
        imageUrl: "https://i.pinimg.com/736x/36/c5/3d/36c53d953e818f7f2536bf75f6240ee3.jpg",
    },
    {
        name: "清水寺",
        address: "京都府京都市東山区清水1丁目294",
        tags: ["寺", "秋"],
        imageUrl: "https://i.pinimg.com/736x/36/c5/3d/36c53d953e818f7f2536bf75f6240ee3.jpg",
    },
    {
        name: "金閣寺",
        address: "京都府京都市北区金閣寺町1",
        tags: ["寺", "春"],
        imageUrl: "https://i.pinimg.com/736x/36/c5/3d/36c53d953e818f7f2536bf75f6240ee3.jpg",
    },
    {
        name: "姫路城",
        address: "兵庫県姫路市本町68",
        tags: ["城", "夏"],
        imageUrl: "https://i.pinimg.com/736x/36/c5/3d/36c53d953e818f7f2536bf75f6240ee3.jpg",
    },
    {
        name: "厳島神社",
        address: "広島県廿日市市宮島町1-1",
        tags: ["神社", "秋"],
        imageUrl: "https://i.pinimg.com/736x/36/c5/3d/36c53d953e818f7f2536bf75f6240ee3.jpg",
    },
    {
        name: "道頓堀",
        address: "大阪府大阪市中央区道頓堀",
        tags: ["街", "夜景"],
        imageUrl: "https://i.pinimg.com/736x/36/c5/3d/36c53d953e818f7f2536bf75f6240ee3.jpg",
    },
];
dumpLocations.forEach((location, index) => {
    const locationCard = document.createElement("div");
    locationCard.className = "w-[250px] p-2 shrink-0 bg-white rounded-[16px] shadow-lg";
    locationCard.innerHTML = `
                    <div class="w-full h-[212px] rounded-[12px] overflow-hidden">
                        <img
                            src="${location.imageUrl}"
                            alt="location-cover"
                            class="object-cover object-center w-full h-full"
                        />
                    </div>
                    <div class="flex flex-col gap-1 px-2 pb-1 mt-4">
                        <h2 class="text-[20px] font-bold">${location.name}</h2>
                        <p class="text-sm font-normal">${location.address}</p>
                        <div class="flex flex-wrap gap-1">
                            ${location.tags
                                .map(
                                    (tag) =>
                                        `<span class="px-3 py-1 text-[10px] font-medium text-white bg-red-400 rounded-sm">${tag}</span>`
                                )
                                .join("")}
                        </div>
                    </div>
                `;
    locationList.appendChild(locationCard);
});

// マップ処理
const locations = [
    {
        lat: 34.6873,
        lng: 135.5259,
        title: "Lâu đài Osaka",
        image: "https://cdn-imgix.headout.com/media/images/8bf2a66bc850615653867aebb013820c-Osaka%20Castle%204.jpg",
        description: "Biểu tượng lịch sử nổi tiếng của Osaka, xây dựng từ thế kỷ 16.",
    },
    {
        lat: 34.6687,
        lng: 135.5012,
        title: "Dotonbori",
        image: "https://www.touristjapan.com/wp-content/uploads/2024/07/Dotonbori-1-1024x683.jpg",
        description: "Khu phố sôi động, nổi tiếng với ẩm thực đường phố và bảng hiệu Glico.",
    },
    {
        lat: 34.6525,
        lng: 135.5063,
        title: "Tháp Tsutenkaku",
        image: "https://www.datocms-assets.com/101439/1705901086-tsutenkaku-tower.webp?auto=format&fit=crop&h=1176&w=1536",
        description: "Biểu tượng lâu đời của khu Shinsekai, có thể lên đỉnh để ngắm thành phố.",
    },
];

let map;
let markers = [];
let currentSelectedMarker = null;
const defaultIcon = "http://maps.google.com/mapfiles/ms/icons/red-dot.png";
const selectedIcon = "http://maps.google.com/mapfiles/ms/icons/blue-dot.png";

function initMap() {
    map = new google.maps.Map(document.getElementById("map"), {
        center: locations[0],
        zoom: 15,
        styles: [
            {
                featureType: "poi", // ẩn các POI (Point of Interest)
                elementType: "labels",
                stylers: [
                    {
                        visibility: "off",
                    },
                ],
            },
            {
                featureType: "poi.business", // ẩn tên doanh nghiệp nhỏ
                stylers: [
                    {
                        visibility: "off",
                    },
                ],
            },
            {
                featureType: "poi.attraction", // ẩn điểm thu hút nhỏ
                stylers: [
                    {
                        visibility: "off",
                    },
                ],
            },
            {
                featureType: "poi.place_of_worship", // ẩn nhà thờ, chùa nhỏ
                stylers: [
                    {
                        visibility: "off",
                    },
                ],
            },
            {
                featureType: "poi.medical", // ẩn bệnh viện nhỏ
                stylers: [
                    {
                        visibility: "off",
                    },
                ],
            },
            {
                featureType: "poi.school", // ẩn trường học nhỏ
                stylers: [
                    {
                        visibility: "off",
                    },
                ],
            },
        ],
    });

    const infoWindow = new google.maps.InfoWindow();

    locations.forEach((location, index) => {
        const marker = new google.maps.Marker({
            position: {
                lat: location.lat,
                lng: location.lng,
            },
            map: map,
            icon: defaultIcon,
            title: location.title,
        });

        marker.addListener("click", () => {
            map.panTo(marker.getPosition());

            // 👉 Đổi icon marker được chọn
            if (currentSelectedMarker) {
                currentSelectedMarker.setIcon(defaultIcon);
            }
            marker.setIcon(selectedIcon);
            currentSelectedMarker = marker;

            // 👉 Làm mờ các marker khác
            markers.forEach((m) => {
                m.setOpacity(m === marker ? 1 : 0.3);
            });
        });

        markers.push(marker);
    });

    map.addListener("click", () => {
        infoWindow.close();
        if (currentSelectedMarker) {
            currentSelectedMarker.setIcon(defaultIcon);
            currentSelectedMarker = null;
        }
        markers.forEach((m) => m.setOpacity(1));
    });
}

window.onload = initMap;
