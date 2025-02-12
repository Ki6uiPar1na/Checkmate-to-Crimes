<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Crime Scene Report</title>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body class="bg-slate-100">
    <div class="min-h-screen p-6 lg:p-8">
      <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg">
        <!-- Header -->
        <div class="border-b border-gray-200 bg-gray-50 rounded-t-xl p-6">
          <div class="flex items-center space-x-3">
            <i data-lucide="file-warning" class="h-8 w-8 text-red-600"></i>
            <h1 class="text-2xl font-bold text-gray-900">Crime Scene Report</h1>
          </div>
          <p class="mt-2 text-sm text-gray-600">
            Please provide detailed information about the crime scene
          </p>
        </div>

        <!-- Form -->
        <form id="crimeSceneForm" class="p-6 space-y-6">
          <!-- Title -->
          <div class="space-y-2">
            <label for="title" class="block text-sm font-medium text-gray-700">
              Title <span class="text-red-500">*</span>
            </label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i data-lucide="heading-1" class="h-5 w-5 text-gray-400"></i>
              </div>
              <input
                type="text"
                id="title"
                name="title"
                required
                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                placeholder="Brief description of the incident"
              />
            </div>
          </div>

          <!-- Description -->
          <div class="space-y-2">
            <label for="description" class="block text-sm font-medium text-gray-700">
              Description <span class="text-red-500">*</span>
            </label>
            <div class="relative">
              <div class="absolute top-3 left-3 pointer-events-none">
                <i data-lucide="file-text" class="h-5 w-5 text-gray-400"></i>
              </div>
              <textarea
                id="description"
                name="description"
                required
                rows="4"
                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                placeholder="Detailed description of the crime scene and incident"
              ></textarea>
            </div>
          </div>

          <!-- Place -->
          <div class="space-y-2">
            <label for="place" class="block text-sm font-medium text-gray-700">
              Place <span class="text-red-500">*</span>
            </label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i data-lucide="map-pin" class="h-5 w-5 text-gray-400"></i>
              </div>
              <input
                type="text"
                id="place"
                name="place"
                required
                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                placeholder="Location of the incident"
              />
            </div>
          </div>

          <!-- Time Fields -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Crime Time -->
            <div class="space-y-2">
              <label for="crimeTime" class="block text-sm font-medium text-gray-700">
                Crime Time <span class="text-red-500">*</span>
              </label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <i data-lucide="clock" class="h-5 w-5 text-gray-400"></i>
                </div>
                <input
                  type="datetime-local"
                  id="crimeTime"
                  name="crimeTime"
                  required
                  class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                />
              </div>
            </div>

            <!-- Global Time (Hidden, automatically set) -->
            <input type="hidden" id="globalTime" name="globalTime" />
          </div>

          <!-- Media Upload -->
          <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-700">
              Evidence Media
            </label>
            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-red-500 transition-colors duration-200">
              <div class="space-y-1 text-center">
                <i data-lucide="upload" class="mx-auto h-12 w-12 text-gray-400"></i>
                <div class="flex text-sm text-gray-600">
                  <label for="media" class="relative cursor-pointer rounded-md font-medium text-red-600 hover:text-red-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-red-500">
                    <span>Upload files</span>
                    <input
                      id="media"
                      name="media"
                      type="file"
                      multiple
                      accept="image/*,video/*"
                      class="sr-only"
                    />
                  </label>
                  <p class="pl-1">or drag and drop</p>
                </div>
                <p class="text-xs text-gray-500">
                  Images or videos up to 10MB each
                </p>
              </div>
            </div>
            <!-- Preview Container -->
            <div id="mediaPreview" class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4"></div>
          </div>

          <!-- Submit Button -->
          <div class="flex justify-end pt-4">
            <button
              type="submit"
              class="px-6 py-3 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200"
            >
              Submit Report
            </button>
          </div>
        </form>
      </div>
    </div>

    <script>
      // Initialize Lucide icons
      lucide.createIcons();

      // Handle file input and preview
      const mediaInput = document.getElementById('media');
      const mediaPreview = document.getElementById('mediaPreview');

      mediaInput.addEventListener('change', function(e) {
        mediaPreview.innerHTML = ''; // Clear previous previews
        
        Array.from(e.target.files).forEach(file => {
          const reader = new FileReader();
          const previewContainer = document.createElement('div');
          previewContainer.className = 'relative aspect-square rounded-lg overflow-hidden border border-gray-200';
          
          reader.onload = function(e) {
            if (file.type.startsWith('image/')) {
              previewContainer.innerHTML = `
                <img src="${e.target.result}" class="w-full h-full object-cover" />
              `;
            } else if (file.type.startsWith('video/')) {
              previewContainer.innerHTML = `
                <video src="${e.target.result}" class="w-full h-full object-cover" controls></video>
              `;
            }
          };
          
          reader.readAsDataURL(file);
          mediaPreview.appendChild(previewContainer);
        });
      });

      // Handle form submission
      document.getElementById('crimeSceneForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Set global time
        document.getElementById('globalTime').value = new Date().toISOString();
        
        const formData = new FormData(e.target);
        const data = Object.fromEntries(formData.entries());
        
        // Log the form data (replace with your actual submission logic)
        console.log('Form submitted:', data);
        
        // You would typically send this data to your server here
        alert('Report submitted successfully!');
      });

      // Set default value for crime time to current date/time
      document.getElementById('crimeTime').value = new Date().toISOString().slice(0, 16);
    </script>
  </body>
</html>