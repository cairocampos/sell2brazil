export default function useJsonPretty() {
  const pattern = /^( *)("[\w]+": )?("[^"]*"|[\w.+-]*)?([,[{])?$/mg;
    const replacer = function(match:string, pIndent:string, pKey:string, pVal:string, pEnd:string) {
        const key = '<span class="json-key" style="color: brown">';
        const val = '<span class="json-value" style="color: navy">';
        const str = '<span class="json-string" style="color: olive">';
        let  r = pIndent || '';
        if (pKey)
            r = r + key + pKey.replace(/[": ]/g, '') + '</span>: ';
        if (pVal)
            r = r + (pVal[0] == '"' ? str : val) + pVal + '</span>';
        return r + (pEnd || '');
    };

    return {
      pattern,
      replacer
    }
}