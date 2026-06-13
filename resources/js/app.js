import './bootstrap';
import Alpine from 'alpinejs'
import instagram from './stores/instagram'

window.Alpine = Alpine

// Register stores
Alpine.store('instagram', instagram)

Alpine.start()