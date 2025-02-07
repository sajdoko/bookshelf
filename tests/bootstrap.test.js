const { getUID, isElement } = require('../assets/bootstrap/js/bootstrap');

test('getUID generates unique IDs', () => {
  const id1 = getUID('prefix');
  const id2 = getUID('prefix');
  expect(id1).not.toBe(id2);
});

test('isElement identifies DOM elements', () => {
  const element = document.createElement('div');
  expect(isElement(element)).toBe(true);
  expect(isElement(null)).toBe(false);
  expect(isElement({})).toBe(false);
});
