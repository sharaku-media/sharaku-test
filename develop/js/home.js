

const locationss = [
  {
    lat: 10.7769,
    lng: 106.7009,
    title: "Cà phê ABC",
    image: "https://via.placeholder.com/200x100",
    description: "Quán cà phê có view đẹp và yên tĩnh."
  },
  {
    lat: 10.7794,
    lng: 106.6992,
    title: "Nhà hàng XYZ",
    image: "https://via.placeholder.com/200x100/ff7f7f",
    description: "Ẩm thực đa dạng, phục vụ chuyên nghiệp."
  },
  {
    lat: 10.7781,
    lng: 106.7030,
    title: "Tiệm bánh 123",
    image: "https://via.placeholder.com/200x100/87cefa",
    description: "Bánh ngọt handmade, vị thơm ngon."
  }
];

let map;
let markers = [];
let currentSelectedMarker = null;
const defaultIcon = "http://maps.google.com/mapfiles/ms/icons/red-dot.png";
const selectedIcon = "http://maps.google.com/mapfiles/ms/icons/blue-dot.png";

function initMap() {
  map = new google.maps.Map(document.getElementById("map"), {
    center: locationss[0],
    zoom: 15,
  });

  const infoWindow = new google.maps.InfoWindow();

  locationss.forEach((location, index) => {
    const marker = new google.maps.Marker({
      position: { lat: location.lat, lng: location.lng },
      map: map,
      icon: defaultIcon,
      title: location.title
    });

    marker.addListener("click", () => {
      const content = `
        <div class="info-box">
          <img src="${location.image}" />
          <h4>${location.title}</h4>
          <p>${location.description}</p>
          <button onclick="alert('Xem chi tiết ${location.title}')">Xem chi tiết</button>
        </div>
      `;
      infoWindow.setContent(content);
      infoWindow.open(map, marker);

      // Highlight marker
      if (currentSelectedMarker) {
        currentSelectedMarker.setIcon(defaultIcon);
      }
      marker.setIcon(selectedIcon);
      currentSelectedMarker = marker;

      // Fade other markers
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