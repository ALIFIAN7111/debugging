import React from 'react'

export default function FloatingWhatsApp({ cartCount }) {
  return (
    <a
      href="https://wa.me/085752376632?text=Halo%20Warmindo%20Smoky%2C%20saya%20ingin%20pesan%20mie%20smoky"
      target="_blank"
      rel="noopener noreferrer"
      className="fixed bottom-6 right-6 w-16 h-16 bg-gradient-to-br from-emerald-500 to-emerald-600 text-white rounded-full flex items-center justify-center text-3xl shadow-2xl hover:shadow-emerald-600/50 transition-all duration-300 z-30 group btn-premium"
      title="Chat WhatsApp Kami"
    >
      {/* Animated background pulse */}
      <div className="absolute inset-0 rounded-full bg-emerald-500 opacity-0 group-hover:opacity-20 animate-pulse" />
      
      {/* Main icon */}
      <span className="relative z-10 transform group-hover:scale-110 transition-transform duration-300">
        💬
      </span>

      {/* Badge with animation */}
      {cartCount > 0 && (
        <span className={`absolute -top-2 -right-2 bg-smoky-ember text-white text-xs font-black w-6 h-6 rounded-full flex items-center justify-center transform transition-all duration-300 ${
          cartCount > 0 ? 'scale-100 animate-pulse' : 'scale-0'
        }`}>
          {cartCount}
        </span>
      )}

      {/* Float animation */}
      <style>{`
        @keyframes float-button {
          0%, 100% {
            transform: translateY(0px);
          }
          50% {
            transform: translateY(-10px);
          }
        }
        
        .fixed.bottom-6.right-6 {
          animation: float-button 3s ease-in-out infinite;
        }
      `}</style>
    </a>
  )
}
