<template>
  <div class="flex flex-col gap-8 h-full p-16">
    <main class="flex h-full gap-8">
      <div class="h-full w-full flex flex-col gap-10">
        <div class="flex flex-row w-full">
          <div class="px-10 py-5 w-full">
            <Button @click="backPage" class="ml-[-15px]" variant="link"> Вернуться </Button>
            <p class="text-xl text-inter-title mb-1">Добавьте новую книгу</p>

            <Input v-model="books" class="mt-5 mb-5" placeholder="Введите название книги" />
            <Input v-model="author" class="mt-5 mb-5" placeholder="Введите автора" />

            <div class="flex items-center space-x-2">
              <Switch @click="activeDownload" />
              <Label for="airplane-mode">Разрешить скачивание</Label>
            </div>

            <p class="mt-5 mb-2">Добавьте обложку</p>
            <div class="flex items-center justify-center w-full">
              <label
                for="cover-file"
                class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600"
              >
                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                  <svg
                    class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400"
                    aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 20 16"
                  >
                    <path
                      stroke="currentColor"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"
                    />
                  </svg>
                  <p
                    class="mb-2 text-sm text-gray-500 dark:text-gray-400"
                    style="text-align: center"
                  >
                    <span class="font-semibold">Перетащите обложку в это окно.</span><br />
                  </p>
                  <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">
                    (только форматы .png, .jpg)
                  </p>
                  <p
                    class="mt-3 text-sm text-gray-500 dark:text-gray-400"
                    style="text-align: center"
                  >
                    <span class="font-semibold"><em>Для выбора нажмите на это окно.</em></span>
                  </p>
                </div>
                <input
                  @change="handleCoverUpload"
                  id="cover-file"
                  type="file"
                  class="hidden"
                  accept=".png,.jpg"
                />
              </label>
            </div>

            <p class="mt-5 mb-2">Добавьте книгу</p>
            <div class="flex items-center justify-center w-full">
              <label
                for="book-file"
                class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600"
              >
                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                  <svg
                    class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400"
                    aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 20 16"
                  >
                    <path
                      stroke="currentColor"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"
                    />
                  </svg>
                  <p
                    class="mb-2 text-sm text-gray-500 dark:text-gray-400"
                    style="text-align: center"
                  >
                    <span class="font-semibold">Перетащите файл в это окно</span><br />
                  </p>
                  <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">
                    Размер до 5мб (только форматы .pdf, .txt)
                  </p>
                  <p
                    class="mt-3 text-sm text-gray-500 dark:text-gray-400"
                    style="text-align: center"
                  >
                    <span class="font-semibold"><em>Для выбора нажмите на это окно.</em></span>
                  </p>
                </div>
                <input
                  @change="handleBookUpload"
                  id="book-file"
                  type="file"
                  class="hidden"
                  accept=".pdf,.txt"
                />
              </label>
            </div>

            <div class="flex justify-end mt-5">
              <Button @click="saveData"> Добавить </Button>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { Input } from '@/components/ui/input'
import { Button } from '@/components/ui/button'
import axios from 'axios'
import { Label } from '@/components/ui/label'
import { Switch } from '@/components/ui/switch'

const router = useRouter()

const coverImage = ref(null)
const bookFile = ref(null)
let checkDownload = ref(false)

const activeDownload = () => {
  checkDownload.value = !checkDownload.value
  console.log(checkDownload.value)
}

const handleCoverUpload = (event) => {
  const file = event.target.files[0]
  if (file) {
    coverImage.value = file
    console.log('Выбранное изображение:', file.name)
  }
}

const handleBookUpload = (event) => {
  const file = event.target.files[0]
  if (file) {
    bookFile.value = file
    console.log('Выбранная книга:', file.name)
  }
}

let author = ref('')
let books = ref('')

const saveData = async () => {
  const formData = new FormData()
  formData.append('books', books.value)
  formData.append('author', author.value)
  formData.append('allow_download', checkDownload.value)
  if (coverImage.value) {
    formData.append('cover_image', coverImage.value)
  }
  if (bookFile.value) {
    formData.append('book_file', bookFile.value)
  }
  formData.append('user_id', localStorage.id_user)

  for (var pair of formData.entries()) {
    console.log(pair[0] + ': ' + pair[1])
  }

  try {
    const response = await axios.post('http://localhost/add-book', formData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    })

    console.log(response.data)
  } catch (error) {
    console.error('Ошибка при отправке данных:', error)
  }
}

const backPage = () => {
  router.push('/')
}
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@800&display=swap');
.text-inter-title {
  font-family: 'Inter', sans-serif;
  font-size: 20px;
  font-weight: 500;
  color: #0f172a;
}
</style>
