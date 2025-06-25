document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("search-input");
    const searchContainer = document.querySelector(".search-container");
    const clearButton = document.querySelector(".clear-search");
    const seasonTags = {
        春: "#41CA4D",
        夏: "#F65F55",
        秋: "#EF7D30",
        冬: "#5D8EF2",
    };

    // 選択されたタグを保持する配列
    let selectedTags = [];
    let searchText = "";

    // タグを検索バーに追加する関数
    function addTagToSearchBar(tagText) {
        if (!selectedTags.includes(tagText)) {
            // タグ要素の作成
            const tagElement = document.createElement("span");
            tagElement.className = "search-tag";
            tagElement.textContent = tagText;

            // 季節タグの場合は背景色を設定
            if (seasonTags[tagText]) {
                tagElement.style.backgroundColor = seasonTags[tagText];
            }

            // 削除イベントの追加
            tagElement.addEventListener("click", () => {
                tagElement.remove();
                selectedTags = selectedTags.filter((tag) => tag !== tagText);
                updateSearchVisibility();
            });

            // 検索バーの前にタグを挿入
            searchContainer.insertBefore(tagElement, searchInput);
            selectedTags.push(tagText);
            updateSearchVisibility();
        }
    }

    // 検索フィールドの表示状態を更新
    function updateSearchVisibility() {
        // クリアボタンの表示制御
        clearButton.style.display = selectedTags.length > 0 ? "flex" : "none";

        // プレースホルダーの表示制御
        if (selectedTags.length > 0) {
            searchInput.placeholder = "";
        } else {
            searchInput.placeholder = "検索";
        }
    }

    // タグボタンの初期化とクリックイベント
    document.querySelectorAll(".tag-button").forEach((button) => {
        const tagText = button.textContent.trim();
        if (seasonTags[tagText]) {
            button.style.backgroundColor = seasonTags[tagText];
        }

        button.addEventListener("click", function () {
            const existingTag = Array.from(searchContainer.querySelectorAll(".search-tag")).find(
                (tag) => tag.textContent === tagText
            );

            if (existingTag) {
                existingTag.remove();
                selectedTags = selectedTags.filter((tag) => tag !== tagText);
                this.classList.remove("selected");
            } else {
                addTagToSearchBar(tagText);
                this.classList.add("selected");
            }
            updateSearchVisibility();
        });
    });

    // クリアボタンのクリックイベント
    clearButton.addEventListener("click", () => {
        searchContainer.querySelectorAll(".search-tag").forEach((tag) => tag.remove());
        selectedTags = [];
        searchInput.value = "";
        searchInput.placeholder = "検索";
        clearButton.style.display = "none";
        document.querySelectorAll(".tag-button").forEach((button) => {
            button.classList.remove("selected");
        });
    });
});
