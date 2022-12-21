<x-jet-action-section>
    <x-slot name="title">{{ __('title.profile.change_language') }}</x-slot>
    <x-slot name="description">{{ __('title.profile.sub_change_language') }}</x-slot>
    <x-slot name="content">
        <div class="mt-5 space-y-6">
            <div class="flex items-center mt-5">
                <div class="form-control">
                    <label class="cursor-pointer label capitalize circle">
                        <span class="label-text text-lg text-left font-semibold" value="en">English</span>
                        <input type="radio" name="language" class="radio ml-4">
                    </label>
                    <label class="cursor-pointer label capitalize circle">
                        <span class="label-text text-lg text-left font-semibold">Vietnamese</span>
                        <input type="radio" name="language" class="radio ml-4" value="vi">
                    </label>
                </div>
            </div>
        </div>
    </x-slot>
</x-jet-action-section>
