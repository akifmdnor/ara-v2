@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sort dropdown logic
            const sortBtn = document.getElementById('sort-dropdown-btn');
            const sortMenu = document.getElementById('sort-dropdown-menu');
            const sortValue = document.getElementById('sort-dropdown-value');
            const sortOptions = sortMenu.querySelectorAll('.sort-option');
            let sortOpen = false;

            sortBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                sortMenu.classList.toggle('hidden');
                sortOpen = !sortOpen;
            });
            sortOptions.forEach(option => {
                option.addEventListener('click', function() {
                    sortValue.textContent = this.textContent;
                    sortMenu.classList.add('hidden');
                    sortOpen = false;
                });
            });
            document.addEventListener('click', function() {
                if (sortOpen) {
                    sortMenu.classList.add('hidden');
                    sortOpen = false;
                }
            });

            // Mobile sort dropdown logic
            const sortBtnMobile = document.getElementById('sort-dropdown-btn-mobile');
            const sortMenuMobile = document.getElementById('sort-dropdown-menu-mobile');
            const sortValueMobile = document.getElementById('sort-dropdown-value-mobile');
            const sortOptionsMobile = sortMenuMobile ? sortMenuMobile.querySelectorAll('.sort-option-mobile') : [];
            let sortOpenMobile = false;
            if (sortBtnMobile && sortMenuMobile) {
                sortBtnMobile.addEventListener('click', function(e) {
                    e.stopPropagation();
                    sortMenuMobile.classList.toggle('hidden');
                    sortOpenMobile = !sortOpenMobile;
                });
                sortOptionsMobile.forEach(option => {
                    option.addEventListener('click', function() {
                        sortValueMobile.textContent = this.textContent;
                        sortMenuMobile.classList.add('hidden');
                        sortOpenMobile = false;
                    });
                });
                document.addEventListener('click', function() {
                    if (sortOpenMobile) {
                        sortMenuMobile.classList.add('hidden');
                        sortOpenMobile = false;
                    }
                });
            }

            // Filter modal logic (mobile only)
            const openFilterBtn = document.getElementById('open-filter-modal');
            const closeFilterBtn = document.getElementById('close-filter-modal');
            const filterModal = document.getElementById('filter-modal');
            if (openFilterBtn && closeFilterBtn && filterModal) {
                openFilterBtn.addEventListener('click', function() {
                    filterModal.classList.remove('hidden');
                });
                closeFilterBtn.addEventListener('click', function() {
                    filterModal.classList.add('hidden');
                });
                filterModal.addEventListener('click', function(e) {
                    if (e.target === filterModal) {
                        filterModal.classList.add('hidden');
                    }
                });
            }
        });
    </script>
@endpush
