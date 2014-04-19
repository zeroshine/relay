# -*- mode: python -*-
a = Analysis(['psseparse.py'],
             pathex=['C:\\Dropbox\\relay'],
             hiddenimports=[],
             hookspath=None,
             runtime_hooks=None)
pyz = PYZ(a.pure)
exe = EXE(pyz,
          a.scripts,
          a.binaries,
          a.zipfiles,
          a.datas,
          name='psseparse.exe',
          debug=False,
          strip=None,
          upx=True,
          console=False , icon='tool.ico')
