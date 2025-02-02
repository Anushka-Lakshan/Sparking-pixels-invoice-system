const { createWindowsInstaller } = require('electron-winstaller');

createWindowsInstaller({
  appDirectory: './dist/Invoice_system-win32-x64',
  outputDirectory: './dist/installer',
  authors: 'Anushka lakshan',
  exe: 'Invoice_system.exe',
  setupExe: 'Invoice_system Installer.exe'
}).then(() => console.log('Installer created successfully!'))
  .catch((e) => console.error('Error creating installer:', e));
