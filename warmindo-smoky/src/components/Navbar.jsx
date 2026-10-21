import React, { useState, useEffect } from 'react'

export default function Navbar({ cartCount, onCartClick }) {
  const [isScrolled, setIsScrolled] = useState(false)

  useEffect(() => {
    const handleScroll = () => {
      setIsScrolled(window.scrollY > 10)
    }

    window.addEventListener('scroll', handleScroll)
    return () => window.removeEventListener('scroll', handleScroll)
  }, [])

  return (
    <nav className={`sticky top-0 z-50 transition-all duration-300 ${
      isScrolled 
        ? 'bg-smoky-dark/95 border-b border-smoky-fire/30 shadow-lg shadow-black/20 backdrop-blur-lg' 
        : 'bg-smoky-dark border-b border-smoky-fire/20 backdrop-blur-md'
    }`}>
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex items-center justify-between h-20">
          {/* Logo with hover animation */}
          <div className="flex items-center gap-2 group cursor-pointer">
            <div className="w-10 h-10 bg-gradient-to-br from-smoky-fire to-smoky-ember rounded-lg flex items-center justify-center text-white font-bold text-lg transform group-hover:scale-110 group-hover:rotate-12 transition-all duration-300">
              🔥
            </div>
            <div className="transform group-hover:translate-x-1 transition-transform duration-300">
              <h1 className="font-display text-xl font-bold text-white">WARMINDO</h1>
              <p className="text-xs text-smoky-fire font-semibold">SMOKY</p>
            </div>
          </div>

          {/* Nav Links - Desktop with hover indicator */}
          <div className="hidden md:flex items-center gap-8">
            {['Beranda', 'Menu', 'Keunggulan', 'Testimoni', 'Lokasi'].map((label, idx) => {
              const href = `#${label.toLowerCase() === 'beranda' ? 'hero' : label.toLowerCase() === 'keunggulan' ? 'features' : label.toLowerCase() === 'testimoni' ? 'testimonials' : label.toLowerCase()}`
              return (
                <a 
                  key={idx}
                  href={href}
                  className="relative text-sm text-gray-300 hover:text-smoky-fire transition-colors duration-300 group"
                >
                  {label}
                  {/* Animated underline on hover */}
                  <span className="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-smoky-fire to-smoky-ember group-hover:w-full transition-all duration-300" />
                </a>
              )
            })}
          </div>

          {/* Cart Button with badge animation */}
          <button
            onClick={onCartClick}
            className="relative flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-smoky-fire to-smoky-ember text-white rounded-lg font-semibold text-sm btn-premium transition-all duration-300"
          >
            🛒 Pesanan
            {cartCount > 0 && (
              <span className={`absolute -top-2 -right-2 bg-smoky-cream text-smoky-dark w-5 h-5 rounded-full flex items-center justify-center text-xs font-bold transform transition-all duration-300 ${
                cartCount > 0 ? 'scale-100 animate-pulse' : 'scale-0'
              }`}>
                {cartCount}
              </span>
            )}
          </button>
        </div>
      </div>
    </nav>
  )
}
