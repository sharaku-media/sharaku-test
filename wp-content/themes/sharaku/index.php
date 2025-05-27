<?php include get_template_directory() . '/parts/header.php'; ?>
<!-- この中に書いていくmain -->
    <!-- body -->
    <div class="px-3">
        <div
            class="w-full mx-auto bg-gray-200 aspect-[2/2.5] rounded-2xl overflow-hidden">
            <!-- map  -->
            <div id="map" class="h-full w-full"></div>
        </div>
    </div>

    <div
        class="absolute flex w-screen gap-4 px-6 pb-4 overflow-scroll bottom-6 location-list-container">
        <!-- location card item -->
        <!-- <div
                key="{index}"
                class="w-[250px] p-2 shrink-0 bg-white rounded-[16px] shadow-lg"
            >
                <div
                    class="w-full h-[212px] rounded-[12px] overflow-hidden"
                >
                    <img
                        src="https://i.pinimg.com/736x/bb/ba/4e/bbba4e9d5ead7cfda8818b7bee2b5ad7.jpg"
                        alt="location-cover"
                        class="object-cover object-center w-full h-full"
                    />
                </div>

                <div class="flex flex-col gap-1 px-2 pb-1 mt-4">
                    <h2 class="text-[20px] font-bold">大阪城</h2>

                    <p class="text-sm font-normal">大阪府大阪市中央区</p>

                    <div class="flex flex-wrap gap-1">
                        {["城", "夏"].map((tag, index) => (
                        <div key="{index}">
                            <span
                                class="px-3 py-1 text-[10px] font-medium text-white bg-red-400 rounded-sm"
                            >
                                {tag}
                            </span>
                        </div>
                        ))}
                    </div>
                </div>
            </div> -->
    </div>
</main>
<?php include get_template_directory() . '/parts/footer.php'; ?>

<!-- <?php get_footer(); ?> -->
