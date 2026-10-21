import React, { useState, useEffect } from 'react'

export default function Testimonials() {
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

    document.querySelectorAll('.testimonial-card').forEach(el => {
      observer.observe(el)
    })

    return () => observer.disconnect()
  }, [])

  const testimonials = [
    {
      name: 'Nabila Putri',
      role: 'Mahasiswi',
      image: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=150&q=80',
      text: 'Aroma smoky mienya beneran berasa dan nagih banget! Kuah nyemeknya pas, topping melimpah. Tempat nongkrong favorit buat tugas sore!',
      id: 'testi-1'
    },
    {
      name: 'Rian Pratama',
      role: 'Content Creator',
      image: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=150&q=80',
      text: 'Level 5 nya gokil pedesnya tapi tetep gurih! Es Teh Jumbonya juga murah. Recommended buat mabar sama temen-temen.',
      id: 'testi-2'
    },
    {
      name: 'Siti Rahma',
      role: 'Food Lover',
      image: 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&w=150&q=80',
      text: 'Warmindo paling bersih dan modern. Pelayanannya ramah cepat meski ramai. Harga bersahabat banget, worth it!',
      id: 'testi-3'
    }
  ]

  return (
    <section id="testimonials" className="py-20 px-4 bg-gradient-to-b from-smoky-dark/95 to-smoky-dark">
      <div className="max-w-7xl mx-auto">
        <div className="text-center mb-12">
          <p className="text-smoky-fire text-xs font-bold uppercase tracking-widest animate-fade-in-up">💬 Testimoni</p>
          <h2 className="font-display text-4xl md:text-5xl font-black text-white mt-2 animate-fade-in-up stagger-1">
            Kata Pelanggan Kami
          </h2>
          <div className="flex items-center justify-center gap-1 mt-3 text-smoky-cream animate-fade-in-up stagger-2">
            {'⭐⭐⭐⭐⭐'.split('').map((star, i) => (
              <span key={i} style={{ transitionDelay: `${i * 50}ms` }} className="inline-block transform hover:scale-125 transition-transform">
                {star}
              </span>
            ))}
            <span className="text-gray-400 text-xs ml-2">4.9/5.0 (500+ ulasan)</span>
          </div>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
          {testimonials.map((testi, idx) => (
            <div 
              key={testi.id}
              id={testi.id}
              className={`testimonial-card relative p-6 bg-smoky-dark/60 border border-smoky-fire/20 rounded-xl hover:border-smoky-fire/50 transition-all duration-300 card-hover flex flex-col justify-between group cursor-pointer ${
                visibleItems[testi.id] ? 'scroll-fade-up visible' : 'scroll-fade-up'
              }`}
              style={{ transitionDelay: visibleItems[testi.id] ? `${idx * 0.1}s` : '0s' }}
            >
              {/* Quote mark accent */}
              <div className="absolute top-3 right-4 text-smoky-fire/20 text-3xl font-bold group-hover:text-smoky-fire/40 transition-colors duration-300">
                "
              </div>

              <p className="text-gray-300 text-sm mb-6 italic leading-relaxed group-hover:text-gray-200 transition-colors duration-300">
                "{testi.text}"
              </p>

              <div className="flex items-center gap-3 pt-4 border-t border-smoky-fire/20">
                <div className="relative">
                  <img
                    src={testi.image}
                    alt={testi.name}
                    className="w-12 h-12 rounded-full object-cover border-2 border-smoky-fire/30 group-hover:border-smoky-fire/60 transition-all duration-300 transform group-hover:scale-110"
                  />
                  <div className="absolute inset-0 rounded-full bg-smoky-fire/0 group-hover:bg-smoky-fire/10 transition-colors duration-300" />
                </div>
                <div>
                  <p className="font-bold text-white text-sm group-hover:text-smoky-fire transition-colors duration-300">
                    {testi.name}
                  </p>
                  <p className="text-xs text-smoky-fire/70 group-hover:text-smoky-fire transition-colors duration-300">
                    {testi.role}
                  </p>
                </div>
              </div>

              {/* Bottom glow on hover */}
              <div className="absolute bottom-0 left-0 right-0 h-0.5 bg-gradient-to-r from-smoky-fire/0 via-smoky-fire to-smoky-fire/0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-b-xl" />
            </div>
          ))}
        </div>
      </div>
    </section>
  )
}
