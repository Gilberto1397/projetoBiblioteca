<template>
  <div v-if="isLoading" class="loading-overlay">
    <div class="loading-spinner">
      <!-- Personalize o conteúdo do loading (pode ser um GIF, SVG, etc.) -->
      <div class="spinner"></div>
      <p>Carregando...</p>
    </div>
  </div>
</template>

<script setup>
defineProps({
  isLoading: {
    type: Boolean,
    required: true
  }
});
</script>

<style scoped>
.loading-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(255, 255, 255, 0.8); /* Overlay semi-transparente */
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 9999; /* Garante que fique acima de tudo */
}

.loading-spinner {
  text-align: center;
}

.spinner {
  width: 40px;
  height: 40px;
  border: 4px solid #f3f3f3;
  border-top: 4px solid #3498db;
  border-radius: 50%;
  animation: spin 1s linear infinite;
  margin: 0 auto 10px;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>