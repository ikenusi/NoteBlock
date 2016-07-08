# NoteBlock
ファイルに記載された独自の記法の楽譜を音符ブロックに起こすPMMPプラグイン

# 使い方
プラグインを導入したPMMPサーバーを起動したときに生成されるNoteBlockフォルダーに楽譜となるファイルと、config.ymlにそのファイル名を記載。  
その後、サーバーを再起動し、音符ブロックを設置してたたくと楽譜にそった音楽が流れ始める  
※パケットの送信速度の関係で音のない間ができたり、音が一気に出たりすることがあります。  

# 楽譜の記法(書き方)
1行で1tick分  
だから改行1つ挟んで1tick分の休み  
音階は[NoteBlock Reference](https://hydra-media.cursecdn.com/minecraft.gamepedia.com/b/bd/Noteblock_reference.png "NoteBlock_Reference")  
音階に-をつけるとバスになる(-1でバスの23、-5でバスの19)  
音階と音階の間に「|」を入れると和音になる(ex 6|10|13)
