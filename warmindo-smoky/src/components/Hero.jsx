import React, { useState, useEffect } from 'react'

export default function Hero({ onOrderClick }) {
  const [isLoaded, setIsLoaded] = useState(false)
  const [mousePosition, setMousePosition] = useState({ x: 0, y: 0 })
  const [imageRotation, setImageRotation] = useState({ x: 0, y: 0 })

  useEffect(() => {
    setIsLoaded(true)
  }, [])

  const handleMouseMove = (e) => {
    const rect = e.currentTarget.getBoundingClientRect()
    const x = (e.clientX - rect.left) / rect.width
    const y = (e.clientY - rect.top) / rect.height
    
    setMousePosition({ x, y })
    
    // Subtle 3D rotation based on mouse position
    setImageRotation({
      x: (y - 0.5) * 8,
      y: (x - 0.5) * -8
    })
  }

  const handleMouseLeave = () => {
    setImageRotation({ x: 0, y: 0 })
  }

  return (
    <section 
      id="hero" 
      className="relative pt-20 pb-32 px-4 overflow-hidden perspective-container"
      onMouseMove={handleMouseMove}
      onMouseLeave={handleMouseLeave}
    >
      {/* Animated background gradient */}
      <div className="absolute inset-0 bg-gradient-to-b from-smoky-fire/10 via-smoky-dark to-smoky-dark pointer-events-none" />
      
      {/* Animated glow orbs */}
      <div className="absolute top-0 right-0 w-96 h-96 bg-smoky-fire/5 rounded-full blur-3xl animate-breathe pointer-events-none" />
      <div className="absolute bottom-20 left-10 w-72 h-72 bg-smoky-ember/5 rounded-full blur-3xl animate-breathe" style={{ animationDelay: '1s' }} />

      <div className="max-w-7xl mx-auto relative z-10">
        <div className="grid md:grid-cols-2 gap-12 items-center">
          {/* Left: Copy with staggered animations */}
          <div className="space-y-6">
            <div 
              className={`inline-block px-3 py-1 bg-smoky-fire/20 border border-smoky-fire/50 rounded-full text-smoky-fire text-xs font-bold ${
                isLoaded ? 'animate-fade-in-left stagger-1' : 'opacity-0'
              }`}
            >
              ⚡ Sensasi Indomie Asap Viral #1
            </div>

            <h1 
              className={`font-display text-5xl md:text-6xl font-black text-white leading-tight ${
                isLoaded ? 'animate-fade-in-up stagger-2' : 'opacity-0'
              }`}
            >
              MIE MANTAP, RASA BERASAP, HARGA BERSAHABAT
            </h1>

            <p 
              className={`text-gray-300 text-lg leading-relaxed max-w-md ${
                isLoaded ? 'animate-fade-in-up stagger-3' : 'opacity-0'
              }`}
            >
              Rasakan kelezatan Indomie khas Warmindo Smoky dengan aroma wajan yang autentik, porsi puas, dan topping melimpah. Sempurna untuk nongkrong, belajar, atau santai.
            </p>

            {/* CTA Buttons with micro-interactions */}
            <div className={`flex flex-col sm:flex-row gap-4 pt-4 ${
              isLoaded ? 'animate-fade-in-up stagger-4' : 'opacity-0'
            }`}>
              <a
                href="#menu"
                className="px-8 py-3 bg-gradient-to-r from-smoky-fire to-smoky-ember text-white rounded-lg font-bold text-center btn-premium transition-all duration-300"
              >
                📖 Lihat Menu
              </a>
              <a
                href="https://wa.me/085752376632?text=Halo%20Warmindo%20Smoky%2C%20saya%20ingin%20pesan%20mie%20smoky"
                target="_blank"
                rel="noopener noreferrer"
                className="px-8 py-3 border-2 border-smoky-fire text-smoky-fire rounded-lg font-bold text-center btn-premium transition-all duration-300 hover:bg-smoky-fire/10"
              >
                💬 Pesan via WhatsApp
              </a>
            </div>

            {/* Stats with stagger */}
            <div className={`pt-8 grid grid-cols-3 gap-4 border-t border-smoky-fire/20 ${
              isLoaded ? 'animate-fade-in-up stagger-5' : 'opacity-0'
            }`}>
              <div className="hover:scale-105 transition-transform duration-300">
                <p className="text-2xl font-black text-smoky-fire">50K+</p>
                <p className="text-xs text-gray-400 mt-1">Porsi Terjual</p>
              </div>
              <div className="hover:scale-105 transition-transform duration-300" style={{ transitionDelay: '0.1s' }}>
                <p className="text-2xl font-black text-white">4.9/5</p>
                <p className="text-xs text-gray-400 mt-1">Rating Google</p>
              </div>
              <div className="hover:scale-105 transition-transform duration-300" style={{ transitionDelay: '0.2s' }}>
                <p className="text-2xl font-black text-smoky-cream">24/7</p>
                <p className="text-xs text-gray-400 mt-1">Selalu Siap</p>
              </div>
            </div>
          </div>

          {/* Right: Image with 3D hover effect */}
          <div className={`relative flex justify-center ${isLoaded ? 'animate-fade-in-right stagger-3' : 'opacity-0'}`}>
            {/* Animated glow background */}
            <div className="absolute -inset-6 bg-gradient-to-r from-smoky-fire/30 to-smoky-ember/30 rounded-3xl blur-3xl animate-breathe" />
            
            {/* 3D Image container */}
            <div 
              className="hero-image-3d relative w-full max-w-sm"
              style={{
                transform: `perspective(1000px) rotateX(${imageRotation.x}deg) rotateY(${imageRotation.y}deg)`,
                transitionDuration: '0.15s',
                transformStyle: 'preserve-3d'
              }}
            >
              <img
                src="https://images.unsplash.com/photo-1612929633738-8fe44f7ec841?auto=format&fit=crop&w=500&q=80"
                alt="Indomie Smoky"
                className="relative w-full rounded-2xl shadow-2xl shadow-smoky-fire/30 border-2 border-smoky-fire/20 transition-shadow duration-300 hover:shadow-smoky-fire/50"
              />
              
              {/* Floating animation on the image */}
              <div className="absolute inset-0 rounded-2xl bg-gradient-to-tr from-smoky-fire/0 via-white/0 to-white/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none" />
            </div>
          </div>
        </div>
      </div>
    </section>
  )
}
