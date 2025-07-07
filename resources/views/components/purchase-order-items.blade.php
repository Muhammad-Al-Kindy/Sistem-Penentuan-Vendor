<!-- MATERIAL TABLE DYNAMIC -->
<div x-data="purchaseOrderItems()" x-init="init()" class="mt-6">
    <div class="flex justify-between items-center mb-2">
        <h2 class="text-md font-semibold">Material</h2>
        <button type="button" @click="addItem"
            class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm flex items-center gap-1">
            <i class="ri-add-line"></i> Tambah Baris
        </button>
    </div>

    <table class="min-w-full divide-y divide-gray-200 text-sm table-auto mb-4">
        <thead class="bg-gray-100 text-gray-600 uppercase tracking-wider">
            <tr>
                <th class="px-4 py-2 text-left">Material</th>
                <th class="px-4 py-2 text-left">Kuantitas</th>
                <th class="px-4 py-2 text-left">Mata Uang</th>
                <th class="px-4 py-2 text-left">VAT</th>
                <th class="px-4 py-2 text-left">Batas Diterima</th>
                <th class="px-4 py-2 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <template x-for="(item, index) in items" :key="index">
                <tr>
                    <td class="px-4 py-2">
                        <select :name="`items[${index}][materialId]`" x-model="item.materialId"
                            class="w-full border border-gray-300 rounded px-2 py-1 focus:ring-blue-500"
                            @change="onMaterialChange(index)">
                            <option value="" disabled selected>Pilih Material</option>
                            @foreach ($materials as $material)
                                <option value="{{ $material->idMaterial }}">{{ $material->namaMaterial }}</option>
                            @endforeach
                            <option value="add_new">+ Tambah Material Baru</option>
                        </select>

                        <!-- Modal for adding new material -->
                        <!-- Modal Tambah Material -->
                        <div x-show="showAddMaterialModal" x-cloak
                            class="fixed inset-0 z-50 flex items-center justify-center bg-black/30 backdrop-blur-sm"
                            @keydown.window.escape="showAddMaterialModal = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95">

                            <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-lg mx-4">
                                <h2 class="text-xl font-semibold text-gray-800 mb-4">Tambah Material Baru</h2>

                                <!-- Vendor Selection -->
                                <div class="mb-3">
                                    <label for="vendorSelect"
                                        class="block text-gray-700 font-medium mb-1">Vendor</label>
                                    <select id="vendorSelect" x-model="newMaterial.vendorId"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="" disabled>Pilih Vendor</option>
                                        @foreach ($vendors as $vendor)
                                            <option value="{{ $vendor->idVendor }}">{{ $vendor->namaVendor }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Kode Material -->
                                <div class="mb-3">
                                    <input type="text" x-model="newMaterial.kodeMaterial" placeholder="Kode Material"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                                </div>

                                <!-- Nama Material -->
                                <div class="mb-3">
                                    <input type="text" x-model="newMaterial.namaMaterial" placeholder="Nama Material"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                                </div>

                                <!-- Satuan Material -->
                                <div class="mb-3">
                                    <input type="text" x-model="newMaterial.satuanMaterial"
                                        placeholder="Satuan Material"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                                </div>

                                <!-- Deskripsi Material -->
                                <div class="mb-4">
                                    <textarea x-model="newMaterial.deskripsiMaterial" placeholder="Deskripsi Material"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"></textarea>
                                </div>

                                <!-- Material Vendor Price Fields -->
                                <div class="mb-3">
                                    <input type="number" step="0.01" min="0" x-model="newMaterial.harga"
                                        placeholder="Harga"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                                </div>
                                <div class="mb-3">
                                    <input type="text" x-model="newMaterial.mataUang" placeholder="Mata Uang"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                                </div>
                                <div class="mb-3">
                                    <input type="number" step="0.01" min="0" x-model="newMaterial.vat"
                                        placeholder="VAT"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                                </div>

                                <!-- Error Message -->
                                <template x-if="addMaterialError">
                                    <p class="text-red-600 text-sm mb-3" x-text="addMaterialError"></p>
                                </template>

                                <!-- Action Buttons -->
                                <div class="flex justify-end gap-2">
                                    <button type="button"
                                        @click="showAddMaterialModal = false;
                        newMaterial = {kodeMaterial: '', namaMaterial: '', satuanMaterial: '', deskripsiMaterial: '', harga: 0, mataUang: '', vat: 0};
                        addMaterialError = '';"
                                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition text-sm">
                                        Batal
                                    </button>
                                    <button type="button" @click="addNewMaterial"
                                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition text-sm">
                                        Simpan
                                    </button>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" :name="`items[${index}][materialVendorPriceId]`"
                            x-model="item.materialVendorPriceId" />
                    </td>
                    <td class="px-4 py-2">
                        <input type="number" min="1" :name="`items[${index}][kuantitas]`"
                            x-model="item.kuantitas"
                            class="w-full border border-gray-300 rounded px-2 py-1 focus:ring-blue-500"
                            placeholder="Kuantitas">
                    </td>
                    <td class="px-4 py-2">
                        <input type="text" :name="`items[${index}][mataUang]`" x-model="item.mataUang"
                            class="w-full border border-gray-300 rounded px-2 py-1 focus:ring-blue-500"
                            placeholder="Mata Uang">
                    </td>
                    <td class="px-4 py-2">
                        <input type="number" min="0" step="0.01" :name="`items[${index}][vat]`"
                            x-model="item.vat"
                            class="w-full border border-gray-300 rounded px-2 py-1 focus:ring-blue-500"
                            placeholder="VAT">
                    </td>
                    <td class="px-4 py-2">
                        <input type="date" :name="`items[${index}][batasDiterima]`" x-model="item.batasDiterima"
                            class="w-full border border-gray-300 rounded px-2 py-1 focus:ring-blue-500">
                    </td>
                    <td class="px-4 py-2 text-center">
                        <button type="button" @click="removeItem(index)"
                            class="text-red-500 hover:text-red-700 transition text-sm" title="Hapus Baris"
                            x-show="items.length > 1">
                            <i class="ri-delete-bin-line text-lg"></i>
                        </button>
                    </td>
                </tr>
            </template>
        </tbody>
    </table>
</div>


<script>
    function purchaseOrderItems() {
        return {
            items: [{
                materialId: '',
                materialVendorPriceId: '',
                kuantitas: '',
                mataUang: '',
                vat: '',
                batasDiterima: ''
            }],
            vendorId: null,
            vendorName: '',

            init() {
                const vendorSelect = document.getElementById('vendorId');
                this.vendorId = vendorSelect ? vendorSelect.value : null;
                this.vendorName = vendorSelect ? vendorSelect.options[vendorSelect.selectedIndex].text : '';

                if (vendorSelect) {
                    vendorSelect.addEventListener('change', () => {
                        this.vendorId = vendorSelect.value;
                        this.vendorName = vendorSelect.options[vendorSelect.selectedIndex].text;
                        this.items.forEach((_, index) => this.fetchMaterialVendorPrice(index));
                        this.fetchMaterialsByVendor();
                    });
                }

                this.items.forEach((_, index) => this.fetchMaterialVendorPrice(index));
                this.fetchMaterialsByVendor();
            },

            addItem() {
                this.items.push({
                    materialId: '',
                    materialVendorPriceId: '',
                    kuantitas: '',
                    mataUang: '',
                    vat: '',
                    batasDiterima: ''
                });
            },

            removeItem(index) {
                if (this.items.length > 1) {
                    this.items.splice(index, 1);
                }
            },

            fetchMaterialVendorPrice(index) {
                const item = this.items[index];
                if (!this.vendorId || !item.materialId) {
                    item.materialVendorPriceId = '';
                    return;
                }

                fetch(`/material-vendor-prices?vendorId=${this.vendorId}&materialId=${item.materialId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length > 0) {
                            item.materialVendorPriceId = data[0].idMaterialVendorPrice;
                        } else {
                            item.materialVendorPriceId = '';
                        }
                    })
                    .catch(() => {
                        item.materialVendorPriceId = '';
                    });
            },

            onMaterialChange(index) {
                const item = this.items[index];
                if (item.materialId === 'add_new') {
                    this.showAddMaterialModal = true;
                    // Reset the selected material to empty to avoid invalid selection
                    item.materialId = '';
                } else {
                    this.fetchMaterialVendorPrice(index);
                }
            },

            addNewMaterial() {
                if (!this.newMaterial.kodeMaterial.trim()) {
                    this.addMaterialError = 'Kode material tidak boleh kosong.';
                    return;
                }
                if (!this.newMaterial.namaMaterial.trim()) {
                    this.addMaterialError = 'Nama material tidak boleh kosong.';
                    return;
                }
                if (!this.newMaterial.satuanMaterial.trim()) {
                    this.addMaterialError = 'Satuan material tidak boleh kosong.';
                    return;
                }
                this.addMaterialError = '';

                // Include vendorId and vendorName in the newMaterial object
                const payload = {
                    ...this.newMaterial,
                    vendorId: this.newMaterial.vendorId,
                    vendorName: this.vendorName
                };

                fetch('/materials', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: JSON.stringify(payload)
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(data => {
                                if (data.errors) {
                                    this.addMaterialError = Object.values(data.errors).flat().join(' ');
                                } else {
                                    this.addMaterialError = 'Unknown error occurred.';
                                    console.error('Error response:', data);
                                }
                                throw new Error(this.addMaterialError);
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Add new material to materials list and select it
                        this.materials.push(data.material);
                        // Find the last added item and set its materialId to new material's id
                        const lastIndex = this.items.length - 1;
                        this.items[lastIndex].materialId = data.material.idMaterial;
                        this.showAddMaterialModal = false;
                        this.newMaterial = {
                            kodeMaterial: '',
                            namaMaterial: '',
                            satuanMaterial: '',
                            deskripsiMaterial: '',
                            harga: 0,
                            mataUang: '',
                            vat: 0
                        };
                    })
                    .catch(error => {
                        console.error('Error adding material:', error);
                    });
            },

            // Add new reactive properties
            showAddMaterialModal: false,
            newMaterial: {
                kodeMaterial: '',
                namaMaterial: '',
                satuanMaterial: '',
                deskripsiMaterial: ''
            },
            addMaterialError: '',
            materials: window.materials
        }
    }
</script>
