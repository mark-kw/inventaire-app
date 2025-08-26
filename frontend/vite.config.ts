import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'
import tailwindcss from '@tailwindcss/vite'

export default defineConfig({
  plugins: [react(), tailwindcss()],
  server: {
    host: true,
    watch: { usePolling: true, interval: 500 },
    hmr: { protocol: 'ws', host: 'localhost' }
  }
})