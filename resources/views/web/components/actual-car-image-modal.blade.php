{{-- Global Actual Car Image Modal Component --}}
{{-- This modal is controlled by Alpine.js global state --}}

<div x-data="actualCarImageModal()" 
     x-show="isOpen" 
     x-cloak
     @keydown.escape.window="closeModal()"
     @open-car-modal.window="openModal($event.detail)"
     class="fixed inset-0 z-50 flex items-center justify-center"
     style="background-color: rgba(0, 0, 0, 0.75);"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     @click="closeModal()">
    
    {{-- Modal Container --}}
    <div @click.stop
         class="relative flex flex-col overflow-hidden"
         style="background-color: white; border: 1px solid #e4e4e7; border-radius: 12px; box-shadow: 0px 2px 6px 0px rgba(0,0,0,0.05), 0px 6px 24px 0px rgba(0,0,0,0.05); max-width: 90vw; width: 650px; max-height: 90vh;"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95">
        
        {{-- Header --}}
        <div class="relative flex items-center" style="padding: 24px 24px 18px 24px;">
            <p class="flex-1 font-semibold" style="font-size: 18px; line-height: 26px; color: #18181b; font-family: 'Inter', sans-serif;">
                Actual car image
            </p>
            
            {{-- Close Button --}}
            <button @click="closeModal()"
                    class="flex items-center justify-center"
                    style="position: absolute; right: 14px; top: 14px; width: 32px; height: 32px; background-color: white; border: 1px solid #e4e4e7; border-radius: 8px; box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07); cursor: pointer; z-index: 10;"
                    type="button">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 4L4 12M4 4L12 12" stroke="#3f3f46" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>
        
        {{-- Divider --}}
        <div style="height: 1px; background-color: #e4e4e7; width: 100%;"></div>
        
        {{-- Content --}}
        <div class="flex flex-col gap-6 overflow-y-auto" style="padding: 24px; border-bottom: 1px solid #e4e4e7;">
            {{-- Car Name with Brand Logo --}}
            <div class="flex gap-2 items-center">
                <template x-if="modalData.brandLogo">
                    <div class="flex items-center justify-center shrink-0" style="width: 24px; height: 24px;">
                        <img :src="modalData.brandLogo" alt="Brand" class="w-full h-full object-cover" style="max-width: 100%; max-height: 100%; object-fit: cover;">
                    </div>
                </template>
                <p class="font-semibold text-center" style="font-size: 20px; line-height: 30px; color: #18181b; font-family: 'Inter', sans-serif;" x-text="modalData.modelName">
                </p>
            </div>
            
            {{-- Images Section --}}
            <div class="flex flex-col">
                {{-- Main Image Display --}}
                <template x-if="modalData.pictures && modalData.pictures.length > 0">
                    <div>
                        <div class="relative w-full mb-3" style="aspect-ratio: 366/186; border-radius: 4px; overflow: hidden;">
                            <template x-for="(picture, index) in modalData.pictures" :key="index">
                                <img x-show="selectedImageIndex === index"
                                     :src="picture"
                                     :alt="modalData.modelName"
                                     class="absolute inset-0 w-full h-full object-cover"
                                     style="border-radius: 4px;">
                            </template>
                        </div>
                        
                        {{-- Thumbnail Gallery --}}
                        <div class="flex gap-3 overflow-x-auto" style="background-color: #f4f4f5; border-radius: 0 0 4px 4px; padding: 12px 12px 16px 4px;">
                            <template x-for="(picture, index) in modalData.pictures" :key="index">
                                <button @click="selectedImageIndex = index"
                                        class="shrink-0 relative"
                                        :class="selectedImageIndex === index ? 'selected-thumbnail' : ''"
                                        style="width: 84px; height: 84px; border-radius: 4px; overflow: hidden; cursor: pointer; transition: all 0.2s ease;"
                                        :style="selectedImageIndex === index 
                                            ? 'border: 1px solid #ff9ea2; box-shadow: 0px 2px 4px 0px rgba(51,65,85,0.1), 0px 6px 32px 0px rgba(51,65,85,0.1);' 
                                            : 'border: 1px solid #e4e4e7; box-shadow: 0px 2px 4px 0px rgba(51,65,85,0.1), 0px 6px 32px 0px rgba(51,65,85,0.1);'"
                                        type="button">
                                    <img :src="picture"
                                         :alt="modalData.modelName"
                                         class="w-full h-full object-cover">
                                </button>
                            </template>
                        </div>
                    </div>
                </template>
                
                {{-- Fallback if no images --}}
                <template x-if="!modalData.pictures || modalData.pictures.length === 0">
                    <div class="flex items-center justify-center w-full" style="aspect-ratio: 366/186; border-radius: 4px; background-color: #f4f4f5;">
                        <p style="color: #6b6b74;">No images available</p>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>

<script>
    // Global Alpine.js component for the actual car image modal
    function actualCarImageModal() {
        return {
            isOpen: false,
            selectedImageIndex: 0,
            modalData: {
                modelName: '',
                brandLogo: null,
                pictures: []
            },
            
            openModal(data) {
                this.modalData = {
                    modelName: data.modelName || 'Car Model',
                    brandLogo: data.brandLogo || null,
                    pictures: data.pictures || []
                };
                this.selectedImageIndex = 0;
                this.isOpen = true;
                // Prevent body scroll when modal is open
                document.body.style.overflow = 'hidden';
            },
            
            closeModal() {
                this.isOpen = false;
                this.selectedImageIndex = 0;
                // Restore body scroll when modal is closed
                document.body.style.overflow = '';
            }
        }
    }
</script>

<style>
    [x-cloak] {
        display: none !important;
    }
    
    .selected-thumbnail {
        transform: scale(1.05);
    }
</style>

