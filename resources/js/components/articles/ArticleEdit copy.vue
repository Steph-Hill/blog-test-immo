<template>
    <h1>modifier l'article</h1>
    <div v-if="errors">
        <div v-for="(v,k) in errors" :key="k">
            <p v-for="error in v" :key="error">
                {{ error }}
            </p>

        </div>
    </div>

    <form action="" v-on:submit.prevent="saveArticle" enctype="multipart/form-data" >
        <label for="title">Titre</label>
        <input type="text" name="title" id="title" v-model="article.title">
        <br>
        <br>
        <label for="content">Description</label>
        <textarea name="" id="" cols="30" rows="10" v-model="article.content" ></textarea>
        <br>
        <br>
        <label for="image">Image</label>
        <input type="file" @change="newImage">
        
        <file-pond
            name="test"
            label-idle="Drop files here..."
            v-bind:allow-multiple="true"
            accepted-file-types="image/jpeg, image/png"
            v-on:processfile="handleProcessfile"
            v-on:init="handleFilePondInit"
        />
        <button type="submit">Save</button>
    </form>
</template>

<script setup>
import useArticles from '../../composables/articles';
import {onMounted} from 'vue';

/* filePond */
import vueFilePond,{setOptions} from "vue-filepond";
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";

// Create component
const FilePond = vueFilePond(
  FilePondPluginFileValidateType,
  FilePondPluginImagePreview
);
const handleProcessfile = (error,file) =>{
    gallery.value.push(file.serverId)
    console.log("filepond : ",error)
}
const handleFilePondInit = () => {
    console.log('first')

    setOptions({
        server:{
            url:'/filepond',
            headers:{
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }
        }
    })
}

const { errors, article,gallery, updateArticle, getArticle } = useArticles()

const props = defineProps({
    id: {
        required: true,
        type: String
    }
})

onMounted(() => getArticle(props.id))

const saveArticle = async () => {
    
    await updateArticle(props.id)
}
</script>