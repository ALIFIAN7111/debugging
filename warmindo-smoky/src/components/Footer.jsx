import React, { useState, useEffect } from 'react'

export default function Footer() {
  const [visibleItems, setVisibleItems] = useState({})

  useEffect(() => {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          setVisibleItems(prev => ({
            ...prev,
            [entry.target.id]: true
          }))
        }
      })
    }, { threshold: 0.1 })

    document.querySelectorAll('.footer-item').forEach(el => {
      observer.observe(el)
    })

    return () => observer.disconnect()
  }, [])

  return (
    <footer className="bg-smoky-dark border-t border-smoky-fire/20 py-12 px-4">
      <div className="max-w-7xl mx-auto">
        <div className="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
          {/* Brand */}
          <div 
            id="footer-brand"
            className={`footer-item ${
              visibleItems['footer-brand'] ? 'scroll-fade-up visible' : 'scroll-fade-up'
            }`}
          >
            <div className="flex items-center gap-2 mb-4 group cursor-pointer">
              <div className="w-10 h-10 bg-gradient-to-br from-smoky-fire to-smoky-ember rounded-lg flex items-center justify-center text-white font-bold text-lg transform group-hover:scale-110 group-hover:rotate-12 transition-all duration-300">
                🔥
              </div>
              <div className="transform group-hover:translate-x-1 transition-transform duration-300">
                <h3 className="font-display text-lg font-bold text-white">WARMINDO</h3>
                <p className="text-xs text-smoky-fire">SMOKY</p>
              </div>
            </div>
            <p className="text-gray-400 text-xs leading-relaxed group-hover:text-gray-300 transition-colors duration-300">
              Mie Mantap, Rasa Berasap, Harga Bersahabat. Tempat nongkrong terbaik untuk mahasiswa dan pekerja.
            </p>
          </div>

          {/* Quick Links */}
          <div 
            id="footer-links"
            className={`footer-item ${
              visibleItems['footer-links'] ? 'scroll-fade-up visible' : 'scroll-fade-up'
            }`}
            style={{ transitionDelay: visibleItems['footer-links'] ? '0.1s' : '0s' }}
          >
            <h4 className="font-bold text-white mb-4 text-sm">Menu Cepat</h4>
            <ul className="space-y-2 text-xs text-gray-400">
              {['Beranda', 'Menu', 'Keunggulan', 'Lokasi'].map((label, idx) => {
                const href = `#${label.toLowerCase() === 'beranda' ? 'hero' : label.toLowerCase() === 'keunggulan' ? 'features' : label.toLowerCase()}`
                return (
                  <li key={idx} className="group">
                    <a 
                      href={href}
                      className="hover:text-smoky-fire transition-all duration-300 inline-flex items-center gap-1 group-hover:gap-2"
                    >
                      {label}
                      <span className="opacity-0 group-hover:opacity-100 transition-opacity duration-300 transform group-hover:translate-x-1">→</span>
                    </a>
                  </li>
                )
              })}
            </ul>
          </div>

          {/* Social */}
          <div 
            id="footer-social"
            className={`footer-item ${
              visibleItems['footer-social'] ? 'scroll-fade-up visible' : 'scroll-fade-up'
            }`}
            style={{ transitionDelay: visibleItems['footer-social'] ? '0.2s' : '0s' }}
          >
            <h4 className="font-bold text-white mb-4 text-sm">Ikuti Kami</h4>
            <div className="flex gap-4">
              {[
                { icon: '💬', link: 'https://wa.me/085752376632', label: 'WhatsApp' },
                { icon: '📱', link: '#', label: 'TikTok' },
                { icon: '📸', link: '#', label: 'Instagram' }
              ].map((social, idx) => (
                <a 
                  key={idx}
                  href={social.link}
                  target={social.link.startsWith('http') ? '_blank' : undefined}
                  rel={social.link.startsWith('http') ? 'noopener noreferrer' : undefined}
                  className="text-gray-400 hover:text-smoky-fire transition-all duration-300 text-lg transform hover:scale-125 hover:rotate-12 group"
                  title={social.label}
                >
                  {social.icon}
                </a>
              ))}
            </div>
          </div>
        </div>

        <div className="border-t border-smoky-fire/20 pt-8">
          <p className="text-center text-gray-500 text-xs opacity-0 animate-fade-in-up stagger-5">
            © 2026 Warmindo Smoky. Semua hak dilindungi. | Mie Mantap, Rasa Berasap, Harga Bersahabat
          </p>
        </div>
      </div>
    </footer>
  )
}
