import React, { useState, useEffect } from 'react'

export default function Location() {
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

    document.querySelectorAll('.location-card').forEach(el => {
      observer.observe(el)
    })

    return () => observer.disconnect()
  }, [])

  return (
    <section id="location" className="py-20 px-4 bg-smoky-dark border-t border-smoky-fire/20">
      <div className="max-w-7xl mx-auto">
        <div className="grid md:grid-cols-2 gap-12 items-center">
          {/* Info */}
          <div className="space-y-6">
            <div className="animate-fade-in-left">
              <p className="text-smoky-fire text-xs font-bold uppercase tracking-widest">📍 Kunjungi</p>
              <h2 className="font-display text-4xl md:text-5xl font-black text-white mt-2">
                Lokasi & Jam Buka
              </h2>
              <p className="text-gray-400 text-sm mt-2">Datang langsung rasakan suasana nongkrong yang cozy!</p>
            </div>

            <div className="space-y-4">
              {/* Address Card */}
              <div 
                id="location-address"
                className={`location-card p-4 bg-smoky-dark/60 border border-smoky-fire/20 rounded-xl transition-all duration-300 card-hover group cursor-pointer ${
                  visibleItems['location-address'] ? 'scroll-fade-up visible' : 'scroll-fade-up'
                }`}
              >
                <p className="font-bold text-white flex items-center gap-2 group-hover:text-smoky-fire transition-colors duration-300">
                  📍 Alamat
                </p>
                <p className="text-gray-400 text-sm mt-2 group-hover:text-gray-300 transition-colors duration-300">
                  Jl. Merdeka No. 42, Samping Indomaret, Pusat Kota
                </p>
              </div>

              {/* Hours Card */}
              <div 
                id="location-hours"
                className={`location-card p-4 bg-smoky-dark/60 border border-smoky-fire/20 rounded-xl transition-all duration-300 card-hover group cursor-pointer ${
                  visibleItems['location-hours'] ? 'scroll-fade-up visible' : 'scroll-fade-up'
                }`}
                style={{ transitionDelay: visibleItems['location-hours'] ? '0.1s' : '0s' }}
              >
                <p className="font-bold text-white flex items-center gap-2 group-hover:text-smoky-fire transition-colors duration-300">
                  ⏰ Jam Operasional
                </p>
                <p className="text-smoky-cream font-bold mt-2 group-hover:text-white transition-colors duration-300">
                  Buka 11.00 - 02.00 WIB
                </p>
                <p className="text-gray-400 text-xs mt-1">Setiap Hari (Dine-in & Takeaway)</p>
              </div>

              {/* Contact Card */}
              <div 
                id="location-contact"
                className={`location-card p-4 bg-smoky-dark/60 border border-smoky-fire/20 rounded-xl transition-all duration-300 card-hover group cursor-pointer ${
                  visibleItems['location-contact'] ? 'scroll-fade-up visible' : 'scroll-fade-up'
                }`}
                style={{ transitionDelay: visibleItems['location-contact'] ? '0.2s' : '0s' }}
              >
                <p className="font-bold text-white flex items-center gap-2 group-hover:text-smoky-fire transition-colors duration-300">
                  📱 Hubungi Kami
                </p>
                <a
                  href="https://wa.me/085752376632"
                  target="_blank"
                  rel="noopener noreferrer"
                  className="text-smoky-fire hover:text-smoky-cream transition-colors duration-300 font-semibold text-sm mt-2 inline-flex items-center gap-1 group-hover:gap-2"
                >
                  WhatsApp: +62 857-5237-6632
                  <span className="transform group-hover:translate-x-1 transition-transform duration-300">→</span>
                </a>
              </div>

              <a
                href="https://maps.google.com/maps/search/merdeka+pusat+kota"
                target="_blank"
                rel="noopener noreferrer"
                className="block px-6 py-3 bg-gradient-to-r from-smoky-fire to-smoky-ember text-white rounded-lg font-bold text-center btn-premium transition-all duration-300 animate-fade-in-up stagger-5"
              >
                🗺️ Buka di Google Maps
              </a>
            </div>
          </div>

          {/* Map with hover effect */}
          <div className={`relative h-80 rounded-xl overflow-hidden border-2 border-smoky-fire/20 transition-all duration-300 card-hover group animate-fade-in-right stagger-3 ${
            visibleItems['location-map'] ? 'scroll-scale visible' : 'scroll-scale'
          }`} id="location-map">
            <iframe
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.521260322751!2d106.8270321!3d-6.2088!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3e945e34b9d%3A0x5b45e8c4ff1cecb!2sJl.%20Merdeka!5e0!3m2!1sen!2sid!4v1234567890"
              width="100%"
              height="100%"
              style={{ border: 0, filter: 'grayscale(100%) invert(90%) contrast(110%)' }}
              allowFullScreen=""
              loading="lazy"
              referrerPolicy="no-referrer-when-downgrade"
              className="w-full h-full transition-all duration-300 group-hover:filter-none"
            />
            {/* Glow overlay on hover */}
            <div className="absolute inset-0 bg-gradient-to-r from-smoky-fire/0 to-smoky-fire/0 opacity-0 group-hover:opacity-10 transition-opacity duration-300 pointer-events-none" />
          </div>
        </div>
      </div>
    </section>
  )
}
