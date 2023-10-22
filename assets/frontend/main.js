const puppy = document.querySelector('#puppy');
const button = document.querySelector('#animateButton');

  puppy.animate([  // Keyframes
    { transform: 'rotate(0deg)' },
    { transform: 'rotate(5deg)' },
    { transform: 'rotate(0deg)' },
    { transform: 'rotate(-5deg)' }
  ], {
    duration: 500,  // Animation duration
    iterations: Infinity  // Repeat animation infinitely
  });
