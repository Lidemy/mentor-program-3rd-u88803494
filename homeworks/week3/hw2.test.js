const alphaSwap = require('./hw2').default;

describe('hw2', () => {
  it('should return correct answer when str = nick', () => {
    expect(alphaSwap('nick')).toBe('NICK');
  });
  it('should return correct answer when str = Nick', () => {
    expect(alphaSwap('Nick')).toBe('nICK');
  });
  it('should return correct answer when str = ,hEllO122', () => {
    expect(alphaSwap(',hEllO122')).toBe(',HeLLo122');
  });
  it('should return correct answer when str = App,le', () => {
    expect(alphaSwap('App,le')).toBe('aPP,LE');
  });
  it('should return correct answer when str = zBarA', () => {
    expect(alphaSwap('zBarA')).toBe('ZbARa');
  });
});
