import React, { useState, useEffect } from 'react'

export default function Features() {
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

    document.querySelectorAll('.feature-card').forEach(el => {
      observer.observe(el)
    })

    return () => observer.disconnect()
  }, [])

  const features = [
    {
      icon: '🔥',
      title: 'Aroma Smoky Autentik',
      desc: 'Dimasak dengan teknik wajan panas tinggi untuk aroma gurih khas smoky.',
      id: 'feature-1'
    },
    {
      icon: '🍽️',
      title: 'Porsi Puas & Komplit',
      desc: 'Porsi pas dengan topping melimpah dari telur lava hingga sayur segar.',
      id: 'feature-2'
    },
    {
      icon: '💰',
      title: 'Harga Ramah Kantong',
      desc: 'Makan enak dan kenyang tanpa perlu khawatir kantong tipis.',
      id: 'feature-3'
    },
    {
      icon: '🎯',
      title: 'Buka Sampai Larut Malam',
      desc: 'Selalu siap melayani kapan pun kamu ingin makan atau nongkrong.',
      id: 'feature-4'
    }
  ]

  return (
    <section id="features" className="py-20 px-4 bg-smoky-dark border-t border-smoky-fire/20">
      <div className="max-w-7xl mx-auto">
        <div className="text-center mb-12">
          <p className="text-smoky-fire text-xs font-bold uppercase tracking-widest animate-fade-in-up">⭐ Keunggulan</p>
          <h2 className="font-display text-4xl md:text-5xl font-black text-white mt-2 animate-fade-in-up stagger-1">
            Mengapa Warmindo Smoky?
          </h2>
        </div>

        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
          {features.map((feature, idx) => (
            <div 
              key={feature.id}
              id={feature.id}
              className={`feature-card relative p-6 bg-smoky-dark/60 border border-smoky-fire/20 rounded-xl hover:border-smoky-fire/50 transition-all duration-300 card-hover group cursor-pointer ${
                visibleItems[feature.id] ? 'scroll-scale visible' : 'scroll-scale'
              }`}
              style={{ transitionDelay: visibleItems[feature.id] ? `${idx * 0.1}s` : '0s' }}
            >
              <div className="text-4xl mb-3 transform group-hover:scale-110 group-hover:rotate-12 transition-transform duration-300">
                {feature.icon}
              </div>
              <h3 className="font-bold text-white mb-2 group-hover:text-smoky-fire transition-colors duration-300">
                {feature.title}
              </h3>
              <p className="text-gray-400 text-xs leading-relaxed group-hover:text-gray-300 transition-colors duration-300">
                {feature.desc}
              </p>
              <div className="absolute bottom-0 left-0 right-0 h-0.5 bg-gradient-to-r from-smoky-fire/0 via-smoky-fire to-smoky-fire/0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-b-xl" />
            </div>
          ))}
        </div>
      </div>
    </section>
  )
}
